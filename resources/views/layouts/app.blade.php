<!DOCTYPE html>
<html lang="{{App::getLocale()}}" @if(App::isLocale('ar'))dir="rtl" @endif>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Oprnize</title>
    <link rel="stylesheet" href="{{asset('auth-assets/fonts/material-icon/css/material-design-iconic-font.min.css')}}">

    <link rel="stylesheet" href="{{asset('auth-assets/css/style.css')}}">
</head>

<body>
    <div class="main">
        <div class="container" style="padding: 0">
            <div class="signup-content">
                <div class="signup-img">
                    <img src="{{asset('auth-assets/images/signup-img.jpg')}}" alt="">
                </div>
                @yield('content')

            </div>
        </div>
    </div>

    <script src="{{asset('auth-assets/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('auth-assets/js/main.js')}}"></script>

</body>

</html>