<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- <link rel="icon" type="image/png" href="images/DB_16х16.png"> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (!empty(config('app.name')) ? config('app.name') : 'laravel') }}</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/typicons.font/typicons.css')}}">

    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('css/front/style.css')}}">
    <!-- endinject -->
    @yield('plugins_css')

    @yield('inline_css')

</head>
<body class="az-body">

    @include('layouts.front.navbar')
    @yield('content_alert')
    @yield('content_body')
    @include('layouts.front.footer')

    {{-- Javascript --}}
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('js/front/script.js') }}"></script>
    @yield('plugins_js')
    @yield('inline_js')
</body>
</html>
