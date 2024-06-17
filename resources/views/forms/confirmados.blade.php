@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">E-mails</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">E-mails</li>
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
                    <h3 class="box-title">E-mails confirmados</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($confirmados->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Seção</th>
                                            <th>Setor</th>
                                            <th>Usuário</th>
                                            <th>Situação</th>
                                            <th class="text-right">Status</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($confirmados as $secao)
                                    <tr>
                                        <td>{{$secao->id}}</td>
                                        <td>{{$secao->descricao}}</td>
                                        <td>{{$secao->setor()->where('id', $secao->setor_id)->pluck('name')->first()?:''}}</td>
                                        <td>{{$secao->usuario()->where('id', $secao->user_id)->pluck('name')->first()?:'Não designado'}}</td>
                                        <td>{{$secao->status()}}</td>
                                        <td class="text-right">
                                            <p class="btn btn-icon {{$secao->btn_email_status()}}" data-toggle="tooltip" data-placement="left" title="{{$secao->email_status()}}"><i class="bx {{$secao->icon_email_status()}}"></i></p>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {!! $confirmados->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
