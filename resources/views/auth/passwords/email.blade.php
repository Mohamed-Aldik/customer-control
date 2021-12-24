@extends('layouts.app')

@section('content')
    <div class="signup-form">

        @if (session('status'))--}}
        <div class="alert alert-info" style="width: max-content">
            <strong><i class="fa fa-check" aria-hidden="true"></i> Check your e-mail.</strong>
        </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="register-form" id="register-form">
            @csrf
            <span style="font-size: 29px;font-weight: bold;color: #545454">Reset Password</span><br><br>
            <span style="margin-top: 5px;font-weight: normal;!important;font-family: Arial!important;color: #a3bbc4;">
                        Enter the email associated with you account and we will send an e-mail with instructions to reset your password
                    </span><br><br><br>

            <div class="inputContainer">
                <label for="name" style="color: #545454">E-mail Address or Phone Number:</label>

                <input class="Field" type="text"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus/>
                @error('email')
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
