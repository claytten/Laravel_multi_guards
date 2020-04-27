@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'admins',
    'second_title'  => 'Admin'
])

@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Update Account</span>
        <h3 class="page-title">{{$employee->name}}</h3>
    </div>
</div>
@endsection

@section('plugins_css')
<link href="{{ asset('plugins/select2/css/select2.css') }}" rel="stylesheet" />
@endsection

@section('content_alert')
<div id="alert_section">
    @if(Session::get('message'))
        <div class="alert alert-result alert-{{ Session::get('status') ? Session::get('status') : 'secondary' }} alert-dismissible fade show mb-0" role="alert">
            <span>{{ Session::get('message') }}</span>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
</div>
@endsection

@section('content_body')
<div class="card">
    <div class="card-body">
        <form action="{{ route('admin.update.account',$employee->id)}}" method="POST" class="form" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="_method" value="PUT" readonly>
            <input type="hidden" name="newPassword" value="oldPassword" readonly>
            <div class="form-group">
                <label>Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $employee->name }}" placeholder="Name">

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            
            <div class="form-group">
                <label>Email</label>
                <input type="text" name="email" id="email" class="form-control @error('email') is-invalid @enderror" value="{{ $employee->email }}" placeholder="Email">

                @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group">
                <label>Image</label>
                <div id="image-container">
                    <div class="form-group image_content">
                        <div class="row">
                            <div class="col-12 col-md-2 text-center">
                                <button type="button" class="btn btn-sm btn-danger d-block mb-2 mx-auto remove_preview" onclick="resetPreview(this)" disabled>Reset Preview</button>
                                @if(!empty($employee->image))
                                    <img class="img-responsive" width="150px;" style="padding:.25rem;background:#eee;display:block;" src="{{ url('/storage'.'/'.$employee->image) }}">
                                @else
                                    <img class="img-responsive" width="150px;" style="padding:.25rem;background:#eee;display:block;">
                                @endif
                            </div>
                            <div class="col-12 col-md-10">
                                <div class="input-group">
                                    <input type="file" accept=".jpg, .jpeg, .png" name="image" class="form-control imgs" onchange="previewImage(this)">
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
            </div>

            <div class="form-group" id="field-brand_id">
                <label>Confirmation Password</label>
                <input type="password" name="confirm_password" id="confirm_password" class="form-control @error('password') is-invalid @enderror" 
                placeholder="Confirmation Password">

                @error('confirm_password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            <div class="form-group mb-0 text-center text-md-right">
                <div class="btn-group">
                    <button type="reset" onclick="resetButtonAccount()" class="btn btn-danger"><i class="material-icons">refresh</i> Reset</button>
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#passwordModal"><i class="material-icons">lock</i> Change Password</button>
                    <button type="submit" class="btn btn-primary"><i class="material-icons">check</i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="passwordModal" tabindex="-1" role="dialog" aria-labelledby="passwordModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <form class="modal-content" id="passwordModalForm" action="{{ route('admin.update.account',$employee->id)}}" method="POST" >
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
                    <input type="password" name="oldpassword" class="form-control @error('oldpassword') is-invalid @enderror" 
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
                        <button type="reset" onclick="resetButtonPassword()" class="btn btn-danger"><i class="material-icons">refresh</i> Reset</button>
                        <button type="submit" class="btn btn-primary"><i class="material-icons">check</i>Submit</button>
                    </div>
                </div>
                
            </div>
        </form>
    </div>
</div>
@endsection

@section('plugins_js')
<script src="{{ asset('plugins/select2/js/select2.js') }}"></script>
<script src="{{ asset('js/validate.js') }}"></script>
@endsection

@section('inline_js')
<script>
    "use strict"
    $(document).ready(function() {
        $('#role').select2({
            'placeholder': 'Select Roles',
        });
    });

    // Add More Image
    function previewImage(input){
        console.log("Preview Image");
        let preview_image = $(input).closest('.image_content').find('.img-responsive');
        let preview_button = $(input).closest('.image_content').find('.remove_preview');

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

    function resetPreview(input){

        let preview_image = $(input).closest('.image_content').find('.img-responsive');
        let preview_button = $(input).closest('.image_content').find('.remove_preview');
        let preview_form = $(input).closest('.image_content').find('.imgs');

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
    }

    function resetButtonPassword() {
        $('#password').hover().focus().css('border-color','#007bff');
        $('#password_confirmation').hover().focus().css('border-color','#007bff');
    }

</script>
@endsection