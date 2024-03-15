@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">LOG Android</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">LOG Android</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">LOG Android</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($log_locals->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped  table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Erro</th>
                                        <th>Versão</th>
                                        <th>Base OS</th>
                                        <th>Codename</th>
                                        <th>Versão SDK</th>
                                        <th>Versão Release</th>
                                        <th>Produto</th>
                                        <th>Espaço</th>
                                        <th>Usuário</th>
                                        <th>Data</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($log_locals as $log_local)
                                        <tr>
                                            <td>{{$log_local->id}}</td>
                                            <td style="word-break: break-all">{{$log_local->error}}</td>
                                            <td>{{$log_local->device_version_number}}</td>
                                            <td style="word-break: break-all">{{$log_local->base_os}}</td>
                                            <td>{{$log_local->codename}}</td>
                                            <td>{{$log_local->version_sdk_int}}</td>
                                            <td>{{$log_local->version_release}}</td>
                                            <td>{{$log_local->product}}</td>
                                            <td>{{$log_local->last_size}}</td>
                                            <td>{{$log_local->username}}</td>
                                            <td>{{optional($log_local->created_at)->format('d/m/Y H:i:s')}}</td>
                                            <td class="text-right">
                                                <a href="{{ route('log_locals.show', $log_local->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $log_locals->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
