@extends('layouts.admin.app',[
    'menu'  => 'accounts',
    'submenu' => 'roles',
    'second_title'  => 'Role Detail'
])
d
@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Role Detail</span>
        <h3 class="page-title">Role</h3>
    </div>
</div>
@endsection

@section('plugins_css')
<link rel="stylesheet" type="text/css" href="{{ asset('plugins/datatable/datatables.css') }}">
@endsection

@section('content_body')
<div class="card">
    <div class="card-header border-bottom">
        <h4 class="mb-0 float-left">{{ $role->name }} Detail</h4>
        <div class="btn-group float-right">
            <a href="{{ route('admin.role.index') }}" class="btn btn-sm btn-secondary"><i class="material-icons">arrow_back</i> Back</a>
            @can('roles-edit')<a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-sm btn-warning text-white"><i class="material-icons">edit</i> Edit</a>@endcan
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped table-hover">
            <tr>
                <th>Role Name</th>
                <td>{{ $role->name }}</td>
            </tr>
            <tr>
                <th>Permissions</th>
                <td>
                    @foreach ($role->permissions as $item)
                        {!! '<label class="badge badge-secondary">'.$item->name.'</label>' !!}
                    @endforeach
                </td>
            </tr>
        </table>

        <div class="card m-4 card-small">
            <div class="card-header">
                <h6 class="mb-0">User with {{ $role->name }} Role</h6>
            </div>
            <div class="card-body p-0 pb-3">
                <table class="table table-striped table-hover" id="usersTable">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <td>Level</td>
                            <td>Status</td>
                            <td>Created At</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($role->employees as $user)
                        <tr>
                            <td>{{ $user->name }}</td>
                            <td>{{ ucwords($user->role) }}</td>
                            <td>{{ $user->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $user->created_at }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@section('plugins_js')
<script type="text/javascript" src="{{ asset('plugins/datatable/datatables.js') }}"></script>
@endsection

@section('inline_js')
<script>
    var postTable = $("#usersTable").DataTable({
        order: [0, 'asc'],
        pageLength: 5,
        aLengthMenu:[5,10,15,25,50],
        responsive: true
    });
</script>
@endsection