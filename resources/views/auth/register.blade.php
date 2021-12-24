@extends('layouts.app')

@section('content')
    <div class="signup-form">
        <form method="POST" class="register-form" action='{{ route("register") }}' id="register-form">
            @csrf
            <span style="font-weight: normal;!important;font-family: Arial!important;color: #a3bbc4;">You allready have an account <a href="{{route('login')}}" style="color: #42e8e0">Log In</a></span><br><br><br>
            <span style="font-size: 29px;font-weight: bold;color: #545454">Hello Welcome!</span><br><br>
            <span style="margin-top: 10px;">Create New Account</span><br><br><br>


            <div class="inputContainer">
                <label for="name" style="color: #545454">Username:</label>
                <i class="fa fa-user icon"> </i>
                <input class="Field" type="text"
                       name="name_en"
                       value="{{old('name_en')}}"
                       placeholder="{{__('Name In English')}}"/>
                @error('name_en')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Email:</label>
                <i class="fa fa-envelope icon"> </i>
                <input class="Field"
                       type="text"
                       name="email"
                       value="{{ old('email') }}"
                       placeholder="{{__('Email')}}"
                       required
                       autocomplete="email"
                />
                @error('email')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Domain:</label>
                <i class="fa fa-globe icon"> </i>
                <input class="Field"
                       type="text"
                       name="domain"
                       value="{{ old('domain') }}"
                       placeholder="{{__('Domain')}}"
                       required
                />
                @error('domain')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Password:</label>
                <i class="fa fa-lock icon"> </i>
                <input class="Field"
                       type="password"
                       placeholder="{{__('Password')}}"
                       name="password"
                       required autocomplete="new-password"
                />
                @error('password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Confirm Password:</label>
                <i class="fa fa-lock icon"> </i>
                <input class="Field"
                       type="password"
                       placeholder="{{__('Confirm Password')}}"
                       name="password_confirmation"
                       required autocomplete="new-password"/>
            </div>


            <div class="form-submit">

                <button style="width: 100%;
    background-color: #19125e;
    border: navajowhite;    font-size: 14px;height: 50px;font-weight: bold; border-bottom-right-radius:21px 13px;" type="submit" class="btn btn-info btn-lg">Sign Up</button>
            </div>
        </form>
    </div>
@endsection
