@extends('layouts.frest_template')
@section('css')
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">SMS</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">SMS</li>
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
                    <h3 class="box-title">SMS</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($smses->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>OS</th>
                                        <th>Telefone</th>
                                        <th>Conteúdo</th>
                                        <th>data_envio</th>
                                        <th>Status</th>
                                        <th>Detalhe do Status</th>
                                        <th>Motivo do Status</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($smses as $sms)
                                        <tr>
                                            <td>{{$sms->id}}</td>
                                            <td>{{$sms->occurrence_id}}</td>
                                            <td>{{$sms->telefone}}</td>
                                            <td>{{$sms->conteudo}}</td>
                                            <td>{{$sms->data_envio()}}</td>
                                            <td>{{$sms->status}}</td>
                                            <td>{{$sms->status_detalhe}}</td>
                                            <td>{{$sms->status_motivo}}</td>
                                            <td class="text-right">
                                                <a href="{{ route('sms.show', $sms->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $smses->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
