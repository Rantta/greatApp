<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;
class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    { 
       // $this->authorize('isAdmin');
       if(\Gate::allows('isAdmin') || \Gate::allows('isAuthor')){
          return User::latest()->paginate(8); 
       }
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name'           => 'required|string|max:191',
            'email'          => 'required|string|email|max:255|unique:users',
            'password'       => 'required|string|min:6',
        ]);
        return   User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'type' => $request['type'],
                'bio' => $request['bio'],
                'password' => hash::make($request['password']),
             ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    public function profile()
    {
        return auth('api')->user();
    }
    
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();
        $this->validate($request, [
            'name'           => 'required|string|max:191',
            'email'          => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password'       => 'sometimes|required|min:6',
        ]);
        $currentPhoto = $user->photo;
        $user = auth('api')->user();
        if($request->photo != $currentPhoto){
            $name = time(). '.' . explode('/', explode(':',substr($request->photo, 0, strpos($request->photo, ';') ))[1])[1];
            \Image::make($request->photo)->save(public_path('img/profile/').$name);
            $request->merge(['photo' => $name]);
            $userPic = public_path('img/profile/').$currentPhoto;
            if(file_exists($userPic)){
                @unlink($userPic);
            }
        }
        if(!empty($request->password)){
            $request->merge(['password' => hash::make($request['password'])]);
        }
        $user->update($request->all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
         $user = User::findOrFail($id);
         $this->validate($request, [
            'name'           => 'required|string|max:191',
            'email'          => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'password'       => 'sometimes|min:6',
        ]);
        if(!empty($request->password)){
            $request->merge(['password' => hash::make($request['password'])]);
        }
        $user->update($request->all());
        return ['message' => 'updated'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');
        $user = User::findOrFail($id);

        $user->delete();
    }
    public function search(){
        if($search = \Request::get('q')){
            $users = User::where(function($query) use ($search){
                $query->where('name', 'LIKE', "%$search%")->orWhere('email','LIKE',"%$search%");
            })->paginate(8);
        }
        return $users;
    }
}
