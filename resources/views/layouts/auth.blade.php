<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>@yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    @yield('css')
</head>

<body class="hold-transition login-page" style="background: url(images/BG.jpg) no-repeat center center fixed;
-webkit-background-size: cover;
-moz-background-size: cover;
-o-background-size: cover;
background-size: cover;">
<div class="container">
    <div class="row">
        <div style="margin-left: 800px; ">
            <div class="login-box" style="margin-bot: 60px;">
                <div class="login-logo">
                    <a class="text-white">{{ config('app.name') }}</a>
                </div>
                <div class="card">
                    <div class="card-body login-card-body">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('js')

</body>

</html>