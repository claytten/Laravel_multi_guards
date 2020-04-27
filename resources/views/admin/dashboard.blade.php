@extends('layouts.admin.app',[
    'menu'  => 'dashboard',
    'second_title' => 'dashboard'
])

@section('content_header')
<div class="page-header row no-gutters py-4">
    <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
        <span class="text-uppercase page-subtitle">Dashboard</span>
        <h3 class="page-title"></h3>
    </div>
</div>
@endsection

@section('content_alert')
@if(Session::get('message'))
    <div class="alert alert-result alert-{{ Session::get('status') ? Session::get('status') : 'secondary' }} alert-dismissible fade show mb-0" role="alert">
        <span>{{ Session::get('message') }}</span>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif
<div id="alert_section"></div>
@endsection

@section('content_body')
<div class="row">
    <div class="col-12 col-md-3">
        <div class="stats-small stats-small--1 card card-small">
            <div class="card-body p-0 d-flex">
                <div class="d-flex flex-column m-auto">
                    <div class="stats-small__data text-center">
                        <span class="stats-small__label text-uppercase">Web Hits</span>
                        <h6 class="stats-small__value count my-3">0</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection