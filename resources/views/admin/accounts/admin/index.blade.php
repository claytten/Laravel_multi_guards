@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'admins',
    'second_title'  => 'Admin'
])

@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Manage Admin</span>
        <h3 class="page-title">Admins</h3>
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
        
        @if(Auth::guard('employee')->user()->can('admin-create'))
        <div class="btn-group float-right">
            <a href="{{ route('admin.admin.create') }}" class="btn btn-sm btn-primary"><i class="material-icons">add</i> Add New</a>
        </div>
        @endif
    </div>
    <div class="card-body p-0 pb-4">
        <table class="table table-striped table-hover" id="usersTable">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($employees as $item)
                    <tr id="rows_{{ $item->id }}">
                        <td>{{ ucwords($item->name) }}</td>
                        <td>{{ $item->email }}</td>
                        <td>{{ $item->role }}</td>
                        <td>{{ $item->is_active ?  'Active' : 'Inactive' }}</td>
                        <td>
                            <div class="dropdown">
                                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" id="dropdownSectionLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</a>
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownSectionLink">
                                    @if(Auth::guard('employee')->user()->can('admin-edit'))
                                        <a href="{{ route('admin.admin.edit', $item->id) }}" class="dropdown-item text-warning"><i class="material-icons text-warning">edit</i> Edit</a>
                                    @endif

                                    {{-- <a href="{{ route('dashboard.admin.show', $item->id) }}" class="dropdown-item text-primary"><i class="material-icons text-primary">info</i> Detail</a> --}}

                                    @if(Auth::guard('employee')->user()->can('admin-delete'))
                                        <button onclick="blockUser('{{ $item->id }}')" class="dropdown-item text-danger" id="block_{{ $item->id }}" {{ $item->is_active ? '' : 'style=display:none' }}><i class="material-icons text-danger">close</i> Block</button>
                                        <button onclick="restoreUser('{{ $item->id }}')" class="dropdown-item text-success" id="restore_{{ $item->id }}" {{ $item->is_active ? 'style=display:none' : '' }}><i class="material-icons text-success">unarchive</i> Restore</button>
                                        <button onclick="deleteUser('{{ $item->id }}')" class="dropdown-item text-danger" id="block_{{ $item->id }}" {{ $item->is_active ? '' : 'style=display:none' }}><i class="material-icons text-danger">restore_from_trash</i> Delete</button>
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
var usersTable = $("#usersTable").DataTable({
    order: [3, 'asc'],
    pageLength: 5,
    aLengthMenu:[5,10,15,25,50],
    language: {
        searchPlaceholder: "Type Here.."
    },
    columnDefs: [
        {
            targets: 4,
            orderable: false,
            searchable: false,
        }
    ],
    responsive: true
});

function deleteUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Destroy, and this user delete anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if(result.value){
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'delete'}, function(result){
                usersTable.row("#rows_"+id).remove().draw();

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

function blockUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });
    
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Non-Active, and this user cannot login anymore!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, block it!'
    }).then((result) => {
        if(result.value){
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'block'}, function(result){
                var row_id = usersTable.row("#rows_"+id).index();
                    
                if(result.user_status){
                    $("#block_"+id).show();
                    $("#restore_"+id).hide();
                    usersTable.cell({row: row_id, column: 3}).data('Active').draw();
                } else {
                    $("#block_"+id).hide();
                    $("#restore_"+id).show();
                    usersTable.cell({row: row_id, column: 3}).data('Inactive').draw();
                }
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

function restoreUser(id){
    $(".alert-result").slideUp(function(){
        $(this).remove();
    });

    
    Swal.fire({
        title: 'Are you sure?',
        text: "This user status will be set to Actived, and this user can login!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Actived it!'
    }).then((result) => {
        $('#loading').show();
        if(result.value){
            $.post("{{ route('admin.admin.index') }}/"+id, {'_token': "{{ csrf_token() }}", '_method': 'DELETE', 'user_action': 'restore'}, function(result){
                var row_id = usersTable.row("#rows_"+id).index();
                    
                if(result.user_status){
                    $("#block_"+id).show();
                    $("#restore_"+id).hide();
                    usersTable.cell({row: row_id, column: 3}).data('Active').draw();
                } else {
                    $("#block_"+id).hide();
                    $("#restore_"+id).show();
                    usersTable.cell({row: row_id, column: 3}).data('Inactive').draw();
                }
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