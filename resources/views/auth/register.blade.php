<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
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

    <!-- style CSS -->
    <link rel="stylesheet" href="{{ asset('css/front/style.css')}}">

  </head>
  <body class="az-body">

    <div class="az-signin-wrapper">
        <div class="az-card-signin">
          <h1 class="az-logo"></h1>
          <div class="az-signin-header">
            <h2>Get Started</h2>
            @if(Session::get('message'))
              <div class="alert alert-outline-{{ Session::get('status') ? Session::get('status') : 'info'}}" role="alert">
                  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                  </button>
                  <strong>{{ Session::get('notice') }}</strong> {{ Session::get('message') }}
              </div><!-- alert -->
            @endif
            <form action="{{ url('/register') }}" method="POST">
              {{ csrf_field() }}
              <div class="form-group">
                <label>Display Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="Enter your display name" value="{{ old('name')}}">
              </div><!-- form-group -->

              <div class="form-group">
                <label>Username</label>
                <input type="username" name="username" id="username" class="form-control @error('username') is-invalid @enderror" placeholder="Enter your username" value="{{ old('username')}}">

                @error('username')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div><!-- form-group -->

              <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email" value="{{ old('email')}}">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div><!-- form-group -->

              <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                placeholder="New Password Min. 5 Character (Must contain a capital, lowercase, and number)" onkeyup="validated()">

                @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div><!-- form-group -->
              <div class="form-group">
                <label>Confirmation Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                placeholder="Re Type Password" onkeyup="validatePassword()">

                @error('password_confirmation')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
              </div><!-- form-group -->
              <button type="submit" class="btn btn-az-primary btn-block">Sign Up</button>
              {{-- <div class="row">
                <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                  <button class="btn btn-block"><i class="fab fa-facebook-f"></i> Signup with <br>Facebook</button>
                </div>
                <div class="col-sm-6 mg-t-10 mg-sm-t-0">
                  <button class="btn btn-primary btn-block"><i class="fab fa-google"></i> Signup with <br>Google</button>
                </div>
              </div> --}}
            </form>
          </div><!-- az-signin-header -->
          <div class="az-signin-footer">
            <p>have an account? <a href="{{ route('login')}}">Sign in</a></p>
          </div><!-- az-signin-footer -->
        </div><!-- az-card-signin -->
      </div><!-- az-signin-wrapper -->

    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/validate.js') }}"></script>
    <script>
      validate.validators.regex = function(value, options, key, attributes) {
          let regExp = new RegExp(options.pattern);
          
          if (!regExp.test(value)) {
              return options.message;
          }
      };
      var constraints = {
          pass: {
              presence: true,
              regex: {
                  pattern: '(?=.*?[0-9])(?=.*?[A-Z])(?=.*?[a-z])',
                  message: "Must contain a capital, lowercase, and number"
              },
              
              length: {
                  minimum: 8
              }
          },
          
          passConfirm: {
              presence: true,
              equality: {
                  attribute: "pass",
                  message: "Passwords do not match",
                  comparator: (v1, v2) => {
                  return v1 === v2;
                  }
              }
          }
      };
      function validated() {
          let pass = {
              pass: $('#password').val()
          };
          let val = validate(pass, constraints);
          console.log(val);
          if(val.pass == undefined) {
              $('#password').hover().focus().css('border-color','#0aff00');
          } else {
              $('#password').hover().focus().css('border-color','red');
          }
      }

      function validatePassword() {
          let pass = {
              pass: $('#password').val(),
              passConfirm: $('#password_confirmation').val()
          };
          let val = validate(pass, constraints);
          if(val == undefined) {
              $('#password_confirmation').hover().focus().css('border-color','#0aff00');
          } else {
              $('#password_confirmation').hover().focus().css('border-color','red');
          }

      }

      function resetButtonAccount() {
          $(".form-control").removeClass('is-invalid');
          $(".invalid-feedback").remove();
      }

      function resetButtonPassword() {
          $('#password').hover().focus().css('border-color','#ced4da');
          $('#password_confirmation').hover().focus().css('border-color','#ced4da');
      }
    </script>
  </body>
</html>