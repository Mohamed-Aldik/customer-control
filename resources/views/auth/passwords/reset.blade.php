@extends('layouts.app')

@section('content')
    <div class="signup-form">
        <form method="POST" action="{{ route('password.update') }}" class="register-form" id="register-form">
            @csrf
            <span style="font-size: 29px;font-weight: bold;color: #545454">Reset Your Password</span><br><br>

            <div class="inputContainer">
                <label for="name" style="color: #545454">E-mail Address or Phone Number:</label>

                <input class="Field"
                       type="text"
                       name="email"
                       placeholder="{{__('Email Address')}}"
                       value="{{ old('email') }}"
                       required
                       autocomplete="email"
                       autofocus/>
                @error('email')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Password:</label>

                <input class="Field"
                       type="password"
                       placeholder="{{__('Password')}}"
                       name="password"
                       required autocomplete="new-password"/>
                @error('password')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="inputContainer">
                <label for="name" style="color: #545454">Confirm Password:</label>

                <input class="Field" \
                       type="password"
                       placeholder="{{__('Confirm Password')}}"
                       name="password_confirmation"
                       required autocomplete="new-password"/>
                @error('password_confirmation')
                <span class="text-danger" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>

            <div class="form-submit">
                <button style="width: 100%;
    background-color: #19125e;
    border: navajowhite;    font-size: 14px;height: 50px;font-weight: bold; border-bottom-right-radius:21px 13px;" type="submit" class="btn btn-info btn-lg">Send</button>
            </div>
        </form>
    </div>
@endsection
