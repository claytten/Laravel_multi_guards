@extends('layouts.front.app')

@section('inline_css')
<style>
    .material-icons {
        font-size: 15px;
    }
</style>
@endsection

@section('content_alert')
@if(Session::get('message'))
    <div class="alert alert-outline-{{ Session::get('status') ? Session::get('status') : 'info'}}" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
        </button>
        <strong>{{ Session::get('notice') }}</strong> {{ Session::get('message') }}
  </div><!-- alert -->
@endif
@endsection

@section('content_body')
<div class="az-content az-content-profile">
    <div class="container mn-ht-100p">
      <div class="az-content-left az-content-left-profile">

        <div class="az-profile-overview">
          <div class="az-img-user">
            <img class="user-avatar rounded-circle mr-2" 
            src="{{ 
                !empty(auth()->user()->image)
                    ? url('/storage'.'/'.auth()->user()->image)
                        : 'https://via.placeholder.com/500x500'
            }}" alt="User Avatar" height="500" width="500">
          </div><!-- az-img-user -->
          <div class="d-flex justify-content-between mg-b-20">
            <div>
              <h5 class="az-profile-name">{{ $customer->name }}</h5>
              <p class="az-profile-name-text">
                @if(Auth::user()->email_verified_at == null)
                    Non-Verified
                    <a href="{{url('/email/resend')}}" class="dropdown-item">Click Here to Verification</a>
                @else 
                    Verified <i class="material-icons">check</i>
                @endif
              </p>
            </div>
          </div>

          <div class="az-profile-bio">
            Genius, Compiler, Powerful Multitasker, Fantasy Fruit Loop, Replacement President of a Major Soft Drink Manufacturer. <a href="">More</a>
          </div><!-- az-profile-bio -->

        </div><!-- az-profile-overview -->

      </div><!-- az-content-left -->
      <div class="az-content-body az-content-body-profile">
        <nav class="nav az-nav-line">
          <a href="" class="nav-link active" data-toggle="tab">Account Settings</a>
        </nav>

        <div class="az-profile-body">
            <div class="col-12 col-md-12">
                <form action="{{ route('accounts.update',Crypt::encrypt($customer->id))}}" method="POST" class="form" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="PUT" readonly>
                    <input type="hidden" name="newPassword" value="oldPassword" readonly>
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Display Name</label>
                        </div><!-- col -->
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                        <input type="text" name="name" id="name" value="{{ $customer->name }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter your firstname">
                        </div><!-- col -->
                        @error('name')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div><!-- row -->
        
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Username</label>
                        </div><!-- col -->
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input type="text" name="username" id="username" value="{{ $customer->username }}" class="form-control @error('username') is-invalid @enderror" placeholder="Enter your lastname">
                        </div><!-- col -->

                        @error('username')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div><!-- row -->
        
                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Email</label>
                        </div><!-- col -->
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input type="email" name="email" id="email" value="{{ $customer->email }}" class="form-control @error('email') is-invalid @enderror" placeholder="Enter your email">
                        </div><!-- col -->

                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div><!-- row -->

                    <div class="row row-xs align-items-center mg-b-20" id="image-container">
                        <div class="col-md-4 image_content">
                            <label>Image</label>
                            @if(!empty($customer->image))
                                <img class="img-responsive" width="150px;" style="padding:.25rem;background:#eee;display:block;" src="{{ url('/storage'.'/'.$customer->image) }}">
                            @else
                                <img class="img-responsive" width="150px;" style="padding:.25rem;background:#eee;display:block;">
                            @endif
                        </div>

                        <div class="col-md-8 d-flex flex-row" >
                            <div class="col-4">
                                <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto remove_preview ml-0" onclick="resetPreview()" disabled>Reset Preview</button>
                            </div>
                            <div class="col-6">
                                <input type="file" accept=".jpg, .jpeg, .png" name="image" class="form-control imgs ml-0" onchange="previewImage(this)">
                            </div>
                        </div>
                    </div><!-- row -->

                    <div class="row row-xs align-items-center mg-b-20">
                        <div class="col-md-4">
                            <label class="form-label mg-b-0">Confirmation Password</label>
                        </div><!-- col -->
                        <div class="col-md-8 mg-t-5 mg-md-t-0">
                            <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('confirm_password') is-invalid @enderror" placeholder="Confirm Password">
                        </div><!-- col -->

                        @error('confirm_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div><!-- row -->

                    <div class="text-right">
                        <button type="button" onclick="resetButtonAccount()" class="btn btn-danger pd-x-30" ><i class="material-icons">refresh</i> Reset</button>
                        {{-- <button type="button" class="btn btn-danger pd-x-30 mg-r-5" data-toggle="modal" data-target="#deactivateModal"><i class="material-icons">delete</i>Deativate Account</button> --}}
                        <button type="button" class="btn btn-warning pd-x-30 mg-r-5" data-toggle="modal" data-target="#passwordModal"><i class="material-icons">lock</i> Change Password</button>
                        <button type="submit" class="btn btn-az-secondary pd-x-30 mg-r-5"><i class="material-icons">check</i> Submit</button>
                    </div>
                </form>
            </div>
        </div><!-- az-profile-body -->
      </div><!-- az-content-body -->
    </div><!-- container -->
</div><!-- az-content -->

<!-- passwordModal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="passwordModalForm" action="{{ route('accounts.update',Crypt::encrypt($customer->id) )}}" method="POST" >
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT" readonly>
            <input type="hidden" name="newPassword" value="changePassword" readonly>
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalTitle">Change Password</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- New Password --}}
                <div class="form-group" id="field-brand_id" id="inputPassword">
                    <label>Old Password</label>
                    <input type="password" name="oldpassword" id="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" 
                    placeholder="Old Password">
    
                    @error('oldpassword')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- /.New Password --}}
                {{-- New Password --}}
                <div class="form-group" id="field-brand_id" id="inputPassword">
                    <label>New Password</label>
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror" 
                    placeholder="New Password Min. 5 Character (Must contain a capital, lowercase, and number)" onkeyup="validated()">
    
                    @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- /.New Password --}}

                {{-- New Password Confirmation --}}
                <div class="form-group" id="field-brand_id">
                    <label>New Password Confirmation</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" 
                    placeholder="Re Type Password" onkeyup="validatePassword()">
    
                    @error('password_confirmation')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                {{-- /.New Password Confirmation--}}
            </div>
            <div class="modal-footer ">
                <div class="form-group mb-0 text-center text-md-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">arrow_back</i>Close</button>
                        <button type="button" onclick="resetButtonPassword()" class="btn btn-danger"><i class="material-icons">refresh</i> Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Submit</button>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>

<!-- deactivateModal -->
<div class="modal fade" id="deactivateModal" tabindex="-1" role="dialog" aria-labelledby="deactivateModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="deactivateModalForm" action="{{ route('accounts.destroy',Crypt::encrypt($customer->id))}}" method="DELETE" >
            {{ csrf_field() }}
            <div class="modal-header">
                <h5 class="modal-title" id="passwordModalTitle">Deactivate Account</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Email</label>
                    <input type="text" name="email" id="email-deactivate" class="form-control @error('email-deactivate') is-invalid @enderror" value="{{ $customer->email }}" placeholder="Email">
    
                    @error('email-deactivate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="form-group" id="field-brand_id">
                    <label>Confirmation Password</label>
                    <input type="password" name="confirm_password" id="confirm-password-deactivate" class="form-control @error('confirm-password-deactivate') is-invalid @enderror" 
                    placeholder="Confirmation Password">
    
                    @error('confirm-password-deactivate')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
            </div>
            <div class="modal-footer ">
                <div class="form-group mb-0 text-center text-md-right">
                    <div class="btn-group">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="material-icons">arrow_back</i>Close</button>
                        <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Submit</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ asset('js/validate.js') }}"></script>
@endsection

@section('inline_js')
<script>
    "use strict"
    // Add More Image
    function previewImage(input){
        console.log("Preview Image");
        let preview_image = $('.image_content').find('.img-responsive');
        let preview_button = $('.remove_preview');
        console.log(input);
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                
                // console.log(e.target.result);
                $(preview_image).attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
            $(preview_button).prop('disabled', false);
        }
    }

    function resetPreview(){

        let preview_image = $('.image_content').find('.img-responsive');
        let preview_button = $('.remove_preview');
        let preview_form = $('.imgs');

        $(preview_image).attr('src', '');
        $(preview_button).prop('disabled', true);
        $(preview_form).val('');
    }

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
        $("#name, #username, #email, #confirm_password").val("");
        resetPreview();
    }

    function resetButtonPassword() {
        $('#password').hover().focus().css('border-color','#ced4da');
        $('#password_confirmation').hover().focus().css('border-color','#ced4da');
        $('#oldpassword, #password, #password_confirmation').val("");
    }
</script>
@endsection