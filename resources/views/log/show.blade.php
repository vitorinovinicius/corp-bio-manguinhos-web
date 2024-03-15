@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Auditoria / Exibir <small>{{$activityLog->name}}</small></h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Auditoria</li>
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
                    <h3 class="box-title">Informações</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>ID</label>
                                    <p class="form-control-static" >{{$activityLog->id}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Nome</label>
                                    <p class="form-control-static" >{{$activityLog->log_name}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Usuário</label>
                                    <p class="form-control-static" >{{(is_object($activityLog->user)) ? $activityLog->user->name . ' <'.$activityLog->user->email.'>': '' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Modelo do Banco</label>
                                    <p class="form-control-static" >{{str_replace("Bureau\\Models\\","",$activityLog->subject_type)}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Id do Modelo</label>
                                    <p class="form-control-static" >{{$activityLog->subject_id}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Efetuado em</label>
                                    <p class="form-control-static" >{{ date('d/m/Y H:i:s', strtotime($activityLog->created_at)) }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @if(isset($jsonDecode['de']))
                            <div class="col-6">
                                <h4>De:</h4>
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped mb-0 table-sm table-hover">
                                        <thead>
                                        <th>Nome</th>
                                        <th>Valor</th>
                                        </thead>
                                        <tbody>
                                        @foreach($jsonDecode['de'] as $key => $item)
                                            <tr>
                                                <td>{!! ucfirst($key) !!}</td>
                                                <td style="word-break: break-word;">{!! $item !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                            @if(isset($jsonDecode['para']))
                            <div class="col-6">
                                <h4>Para:</h4>
                                <div class="table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-striped table-sm table-hover mb-0">
                                        <thead>
                                        <th>Nome</th>
                                        <th>Valor</th>
                                        </thead>
                                        <tbody>
                                        @foreach($jsonDecode['para'] as $key => $item)
                                            <tr>
                                                <td>{!! $key !!}</td>
                                                <td style="word-break: break-word;">{!! $item !!}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
@endsection
