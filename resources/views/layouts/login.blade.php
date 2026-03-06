<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords" content="AxD">
    <meta name="description" content="For Storify">
    <title>@yield('title')</title>
    <link rel="icon" href="{{ asset('images/favicon-16x16.png') }}" type="image/x-icon">

    <!-- Bootstrap Core CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}">

    <!-- Link CSS Storify -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-base-style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/storify-login-style.css') }}">

    <!-- Link fontGoogles -->
    <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,700&amp;display=swap" rel="stylesheet">

    <!-- Link Bootstrap Icon -->
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/bootstrap-icons/font/bootstrap-icons.css') }}">

</head>

<body>

    @yield('content')

    <script src="https://ajax.cloudflare.com/cdn-cgi/scripts/7089c43e/cloudflare-static/rocket-loader.min.js"
        data-cf-settings="5e21a29fae5ef848579f15e8-|49" defer=""></script>

    <!-- Javascript Customs -->
    <script type="text/javascript" src="{{ asset('js/javascript-icon-password.js') }}"></script>

</body>

</html>
