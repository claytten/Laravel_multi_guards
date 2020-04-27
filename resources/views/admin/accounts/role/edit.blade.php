@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'roles',
    'second_title'  => 'Role'
])
@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Update Role</span>
        <h3 class="page-title">Role</h3>
    </div>
</div>
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
        <form action="{{ route('admin.admin.update',$role->id)}}" method="POST" class="form">
            {{ csrf_field() }}
            @method('PUT')

            <div class="form-group">
                <label>Role Name</label>
                <input type="text" name="name" id="name" class="form-control @error('name') is-invalid @enderror" value="{{ $role->name }}" placeholder="Name">

                @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
                
            <div class="alert alert-result alert-info fade show mb-0" role="alert">
                <span><i class="material-icons">warning</i> To assign create, edit, and delete permission, list permission is needed!</span>
            </div>

            @foreach ($options as $key => $item)
            <fieldset class="form-group">
                <legend class="col-form-label">{{ ucwords(str_replace('_', ' - ', $key)) }}</legend>
                <div class="row">
                    @foreach ($item as $value)
                    <div class="col-12 col-md-3">
                        <div class="custom-control custom-checkbox mb-1">
                            <input class="custom-control-input" type="checkbox" name="permissions[]" value="{{ $key.'-'.$value }}" id="{{ $key.'-'.$value }}" {!! $value != 'list' ? 'disabled' : "onchange=listCheck('".$key."')" !!}>
                            <label for="{{ $key.'-'.$value }}" class="custom-control-label">{{ ucwords($value) }}</label>
                        </div>
                    </div>
                    @endforeach
                </div>
            </fieldset>
            @endforeach

            <div class="form-group mb-0 text-center text-md-right">
                <div class="btn-group">
                    <a href="{{ route('admin.role.index') }}" class="btn btn-secondary"> Back</a>
                    <button type="reset" id="btn-reset'" class="btn btn-danger"><i class="material-icons">refresh</i> Reset</button>
                    <button type="submit" class="btn btn-primary"><i class="material-icons">check</i> Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('inline_js')
<script>
    var key_list = [
        @foreach($options as $key => $value)
        '{{ $key }}',
        @endforeach
    ]

    var key_old = [];
    @foreach($old_options as $permission)
        key_old.push("{{ $permission }}");
    @endforeach

    $(document).ready(function(){
        key_list.forEach(function(obj){
            if(key_old.includes(obj+'-list')){
                $("#"+obj+'-list').prop('checked', true);
            }

            listCheck(obj);
        });
    });

    function listCheck(permission){
        console.log("Check Permission is running...");

        if($("#"+permission+"-list").prop('checked') === true){
            $("#"+permission+'-create').attr('disabled', false);
            $("#"+permission+'-edit').attr('disabled', false);
            $("#"+permission+'-delete').attr('disabled', false);

            if(key_old.includes(permission+'-create')){
                $("#"+permission+'-create').prop('checked', true);
            } else {
                $("#"+permission+'-create').prop('checked', false);
            }

            if(key_old.includes(permission+'-edit')){
                $("#"+permission+'-edit').prop('checked', true);
            } else {
                $("#"+permission+'-edit').prop('checked', false);
            }

            if(key_old.includes(permission+'-delete')){
                $("#"+permission+'-delete').prop('checked', true);
            } else {
                $("#"+permission+'-delete').prop('checked', false);
            }
        } else {
            $("#"+permission+'-create').prop('checked', false).attr('disabled', true);
            $("#"+permission+'-edit').prop('checked', false).attr('disabled', true);
            $("#"+permission+'-delete').prop('checked', false).attr('disabled', true);
        }
    }

    $("#btn-reset").click(function(e){
        e.preventDefault();
        let obj_status;

        $("#name").val('{{ $role->name }}');

        key_list.forEach(function(obj){
            if(key_old.includes(obj+'-list')){
                obj_status = true;
                console.log(obj+"-list is checked");
                // $("#"+obj+'-list').prop('checked', true);
            } else {
                obj_status = false;
                console.log(obj+"-list is un-checked");
                // $("#"+obj+"-list").prop('checked', false);
            }

            $("#"+obj+'-list').prop('checked', obj_status);
            listCheck(obj);
        });
    });
</script>
@endsection