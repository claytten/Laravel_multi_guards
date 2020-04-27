@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'roles',
    'second_title'  => 'Role'
])
@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Manage Role</span>
        <h3 class="page-title">Roles</h3>
    </div>
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/datatables.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
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
    <div class="card-header border-bottom">
        <h4 class="mb-0 float-left">Admin List</h4>
        
        @if(Auth::guard('employee')->user()->can('roles-create'))
        <div class="btn-group float-right">
            <a href="{{ route('admin.role.create') }}" class="btn btn-sm btn-primary"><i class="material-icons">add</i> Add New</a>
        </div>
        @endif
    </div>
    <div class="card-body p-0 pb-4">
        <table class="table table-striped table-hover" id="rolesTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>User Assigned</th>
                    <th>Permission Count</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($roles as $item)
                    <tr id="rows_{{ $item->id }}">
                        <td>{{ucwords($item->name)}}</td>
                        <td>{{ $item->employees_count }}</td>
                        <td>{{$item->permissions_count}}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownSectionLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownSectionLink">
                                    @if(Auth::guard('employee')->user()->can('roles-edit'))
                                        <a href="{{ route('admin.role.edit', $item->id) }}" class="dropdown-item text-warning"><i class="material-icons text-warning">edit</i> Edit</a>
                                        <a href="{{ route('admin.role.show', $item->id) }}" class="dropdown-item text-primary"><i class="material-icons text-primary">remove_red_eye</i>Details</a>
                                    @endif

                                    @if(Auth::guard('employee')->user()->can('roles-delete'))
                                        <button onclick="deleteRole('{{ $item->id }}')" class="dropdown-item text-danger"><i class="material-icons text-danger">restore_from_trash</i> Delete</button>
                                    @endif
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('plugins/datatable/datatables.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/sweetalert2/sweetalert2.js') }}"></script>

@endsection

@section('inline_js')
<script>
var rolesTable = $("#rolesTable").DataTable({
    order: [2, 'asc'],
    pageLength: 5,
    aLengthMenu:[5,10,15,25,50],
    language: {
        searchPlaceholder: "Type Here.."
    },
    columnDefs: [
        {
            targets: 3,
            orderable: false,
            searchable: false,
        }
    ]
});
function deleteRole(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    $('#loading').append(`
        <div id="p7" class="mdl-progress mdl-js-progress mdl-progress__indeterminate progress--colored-light-blue loading"></div>
    `);
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Destroy, and this user delete anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        $('#loading').show();
        if(result.value){
            $.post("{{ route('admin.role.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE'}, function(result){
                rolesTable.row("#rows_"+id).remove().draw();

                // Append Alert Result
                $('<div class="alert alert-result alert-'+result.status+' alert-dismissible fade show mb-0" role="alert"><span>'+result.message+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>').appendTo($("#alert_section")).slideDown("slow", "swing");
            }).fail(function(jqXHR, textStatus, errorThrown){

                $.each(jqXHR.responseJSON.errors, function(key, result) {
                    $('<div class="alert alert-result alert-danger alert-dismissible fade show mb-0" role="alert"><span>'+jqXHR.responseText+'</span><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>')
                    .appendTo($("#alert_section"))
                    .slideDown("slow", "swing");
                });
            });
        }
    });
}
</script>
@endsection