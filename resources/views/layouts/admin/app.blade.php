<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <!-- <link rel="icon" type="image/png" href="images/DB_16х16.png"> -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ (!empty(config('app.name')) ? config('app.name') : 'DarkCrown Dashboard').(!empty($second_title) ? ' - '.$second_title : '') }}</title>

    <!-- Add to homescreen for Chrome on Android -->
    <meta name="mobile-web-app-capable" content="yes">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Add to homescreen for Safari on iOS -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
    <meta name="apple-mobile-web-app-title" content="{{ config('app.name') }}">

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/shards-dashboards.1.1.0.css') }}" id="main-stylesheet" data-version="1.1.0">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/extras.1.1.0.min.css') }}">
    <!-- endinject -->
    @yield('plugins_css')

    @yield('inline_css')

</head>
<body class="h-100">
    <div class="container-fluid">
        <div class="row">
            <!-- Main Sidebar -->
            @include('layouts.admin.sidebar')
            <!-- End Main Sidebar -->
            <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                @include('layouts.admin.navbar')
                <!-- / .main-navbar -->
                <div class="main-content">

                    @yield('content_alert')
                    <div class="main-content-container container-fluid px-4 pb-4">
                        <!-- Page Header -->
                        @yield('content_header')
                        <!-- End Page Header -->

                        <!-- Page Content -->
                        @yield('content_body')
                        <!-- End Page Content -->
                    </div>
                </div>
                @include('layouts.admin.footer')
            </main>
        </div>
    </div>

    {{-- Javascript --}}
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    @yield('plugins_js')
    @yield('inline_js')

    {{-- Javascript --}}
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/shards.min.js') }}"></script>
    <script src="{{ asset('js/shards.1.1.0.js') }}"></script>
    <script src="{{ asset('js/extras.1.1.0.min.js') }}"></script>
</body>
</html>
