@extends('log')

@section('content')
    <div class="row justify-content-center" style="padding-top:100px;">
    <div class="col-md-6 reg">
       <h1>The Most Complete Social Network is Here!</h1>
       <p>We are the best and biggest social network with 5 billion active users all around the world. Share you thoughts, write blog posts, show your favourite music via Stopify, earn badges and much more!</p>
       <button><a href="{{ route('register') }}">Register Now!</a></button>    
    </div>
        <div class="col-md-6">
            <div class="card card-log">
                <div class="card-header">{{ __('Login') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="email" type="email" placeholder="Your Email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <input id="password" type="password" placeholder="Password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12 offset-md-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                    <label class="form-check-label" for="remember">
                                        {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-12 offset-md-12">
                                <button type="submit" class="btn btn-success" style="display:block">
                                    Login
                                </button>
                                <a href="{{ url('/login/google') }}" class="btn btn-danger yea"><i class="fab fa-google-plus-g"></i> Google</a>
                                <a href="{{ url('/login/facebook') }}" class="btn btn-primary yea"><i class="fab fa-facebook-square"></i> Facebook</a>


                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" style="text-align:start;padding-left: initial;display:block;" href="{{ route('password.request') }}">
                                        {{ __('Forgot Your Password?') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
