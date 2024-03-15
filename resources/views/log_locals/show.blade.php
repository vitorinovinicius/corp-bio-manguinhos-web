@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">LOG Android / Exibir #{{$log_local->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">LOG Android</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do LOG Android - Exibir #{{$log_local->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">error</label>
                                    <p class="form-control-static" >{{ $log_local->error }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">device_version_number</label>
                                    <p class="form-control-static" >{{ $log_local->device_version_number }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">base_os</label>
                                    <p class="form-control-static" >{{ $log_local->base_os }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">codename</label>
                                    <p class="form-control-static" >{{ $log_local->codename }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">version_sdk_int</label>
                                    <p class="form-control-static" >{{ $log_local->version_sdk_int }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">version_release</label>
                                    <p class="form-control-static" >{{ $log_local->version_release }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">product</label>
                                    <p class="form-control-static" >{{ $log_local->product }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">last_size</label>
                                    <p class="form-control-static" >{{ $log_local->last_size }}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">username</label>
                                    <p class="form-control-static" >{{ $log_local->username }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="btn btn-link" href="{{ route('log_locals.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
@endsection
