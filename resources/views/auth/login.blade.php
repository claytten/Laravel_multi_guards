<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <!-- Meta -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- vendor css -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/ionicons/css/ionicons.min.css')}}">
    <link rel="stylesheet" href="{{ asset('plugins/typicons.font/typicons.css')}}">
    <link rel="stylesheet" href="{{ asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('css/front/style.css')}}">

  </head>
  <body class="az-body">

    <div class="az-signin-wrapper">
      <div class="az-card-signin">
        <h1 class="az-logo"></h1>
        <div class="az-signin-header">
          <h2>Welcome back!</h2>
          <h4>Please sign in to continue</h4>
          @if(Session::get('message'))
              <div class="alert alert-outline-{{ Session::get('status') ? Session::get('status') : 'info'}}" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ Session::get('notice') }}</strong> {{ Session::get('message') }}
            </div><!-- alert -->
          @endif
          <form action="{{ route('login') }}" method="POST">
            {{ csrf_field() }}
            <div class="form-group">
              <label>Username/Email</label>
              <input type="text" id="email" class="form-control" placeholder="Enter your username/email" name="email" value="{{ old('email') }}">
              @error('email')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div><!-- form-group -->
            <div class="form-group">
              <label>Password</label>
              <input type="password" id="password" class="form-control" placeholder="Enter your password" name="password" value="{{ old('password') }}">
              @error('password')
                  <span class="invalid-feedback" role="alert">
                      <strong>{{ $message }}</strong>
                  </span>
              @enderror
            </div><!-- form-group -->
            <button type="submit" class="btn btn-az-primary btn-block">Sign In</button>
          </form>
        </div><!-- az-signin-header -->
        <div class="az-signin-footer">
          <p>Don't have an account? <a href="{{ route('register') }}">Create an Account</a></p>
        </div><!-- az-signin-footer -->
      </div><!-- az-card-signin -->
    </div><!-- az-signin-wrapper -->

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('plugins/ionicons/ionicons.js') }}"></script>
    <script src="{{ asset('js/front/script.js') }}"></script>
  </body>
</html>