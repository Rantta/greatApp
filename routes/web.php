<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('login/{social}', 'Auth\LoginController@redirectToProvider');
Route::get('login/{social}/callback', 'Auth\LoginController@handleProviderCallback');
Route::get('/js/popper.js.map', function () {
    return view('welcome');
});
Route::get('/contact', function () {
    return view('private');
})->middleware('auth');
Route::get('messages', 'MessageController@fetchMessages');
Route::post('messages', 'MessageController@sendMessage');
Route::get('/peoples', 'HomeController@peoples')->name('peoples');
Route::get('/private', 'HomeController@private')->name('private');
Route::get('/private-message/{user}', 'MessageController@privateMessage')->name('privateMssage');
Route::post('/private-message/{user}', 'MessageController@sendPrivateMessage')->name('privateMssage.store');
Route::get('{path}','HomeController@index')->where('path','([A-z\_-\d]+)?');