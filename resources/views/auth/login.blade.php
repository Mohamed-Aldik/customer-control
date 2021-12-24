@extends('layouts.app')

@section('content')
    <div class="signup-form">
        <form method="POST" class="register-form" action="{{route('login')}}" id="register-form">
            @csrf
            <span style="font-weight: normal;!important;font-family: Arial!important;color: #a3bbc4;">You don't have an account <a href="{{route('register')}}" style="color: #42e8e0">Sign up</a></span><br><br><br>
            <span style="font-size: 29px;font-weight: bold;color: #545454">Hello, Welcome Back!</span><br><br>
            <span style="margin-top: 10px;font-weight: normal;!important;font-family: Arial!important;color: #a3bbc4;">Sign in if you have an account</span><br><br><br>
            <div class="row" style="margin-left: -5px !important;">
                <div class="pull-left">
                    <img src="{{asset('assets/media/users/default.jpg')}}" class="img-responsive " style="height: 75px; border-radius: 50%" >

                </div>
                <div class="" style="margin-top: 33px;margin-left: 94px;">
                    <span class="pull-left" style="font-weight: bolder">Organization</span>
                </div>

            </div><br><br>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Email:</label>
                <i class="fa fa-envelope icon"> </i>
                <input class="Field"
                       type="text"
                       value="{{ old('email') }}"
{{--                       type="email"--}}
                       placeholder="{{__('example40@gmail.com')}}"
                       name="email"
                       required autocomplete="email" autofocus
                />

                @error('email')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="inputContainer">
                <label for="name" style="color: #545454">Password:</label>
                <i class="fa fa-lock icon"> </i>
                <input class="Field" type="password"
                       placeholder="{{__('Password')}}"
                       name="password"
                       required autocomplete="current-password"/>
                @error('password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror

            </div>

            <input type="checkbox" name="r" />

            <a href="{{route('password.request')}}" style="color: #42e8e0;font-weight: bold;font-size: 11px; ">Forget Password ?</a>

            <div class="form-submit">
                <button style="width: 100%;
    background-color: #19125e;
    border: navajowhite;    font-size: 14px;height: 50px;font-weight: bold; border-bottom-right-radius:21px 13px;" type="submit" class="btn btn-info btn-lg">Login</button>
            </div>
        </form>
    </div>
@endsection
