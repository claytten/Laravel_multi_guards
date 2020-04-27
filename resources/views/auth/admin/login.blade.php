<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>

    <link href='https://fonts.googleapis.com/css?family=Roboto:400,500,300,100,700,900' rel='stylesheet'
          type='text/css'>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- inject:css -->
    <link rel="stylesheet" href="{{ asset('css/lib/getmdl-select.min.css')}}">
    <link rel="stylesheet" href="{{ asset('css/application.min.css')}}">
    <!-- endinject -->

</head>
<body>

<div class="mdl-layout mdl-js-layout color--gray is-small-screen login">
    <main class="mdl-layout__content">
        <div class="mdl-card mdl-card__login mdl-shadow--2dp">
                <div class="mdl-card__supporting-text color--dark-gray">
                    <div class="mdl-grid">
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                        <a href="{{route('home')}}">
                            <span class="mdl-card__title-text text-color--smooth-gray">
                                {{config('app.name')}}
                            </span>
                        </a>
                        </div>
                        @if(Session::get('message'))
                            <div class="alert alert-warning alert-dismissible fade show mb-0" role="alert">
                                <span>{{ Session::get('message') }}</span>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                            <span class="login-name text-color--white">Sign in</span>
                        </div>
                        <form action="{{ route('admin.login') }}" method="POST">
                            {{ csrf_field() }}
                            <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone">
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                    <input class="mdl-textfield__input @error('email') is-invalid @enderror" type="text" id="email" name="email" value="{{ old('email') }}" autocomplete="email" autofocus>
                                    <label class="mdl-textfield__label" for="e-mail">Email</label>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label full-size">
                                    <input class="mdl-textfield__input @error('password') is-invalid @enderror" type="password" id="password" name="password" value="{{ old('password') }}">
                                    <label class="mdl-textfield__label" for="password">Password</label>
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mdl-cell mdl-cell--12-col mdl-cell--4-col-phone submit-cell">
                                <div class="mdl-layout-spacer"></div>
                                <button type="submit" class="mdl-button mdl-js-button mdl-button--raised color--light-blue">
                                    SIGN IN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    </main>
</div>

<!-- inject:js -->
<script src="{{asset('js/getmdl-select.min.js')}}"></script>
<script src="{{asset('js/material.min.js')}}"></script>
<!-- endinject -->

</body>
</html>