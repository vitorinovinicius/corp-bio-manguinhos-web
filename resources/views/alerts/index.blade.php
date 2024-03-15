@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Alertas - Painel de Alertas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Alertas</li>
                        <li class="breadcrumb-item active">Painel de Alertas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    @include("alerts.filters")
    @include("alerts.contador")

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="box-title">Alertas para {{request()->get('created_at') ? request()->get('created_at') : "Hoje" }} - ({{$alerts->total()}})</h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($alerts->count())
                            <div class="table-responsive">
                                <table class="table table-striped table-sm table-hover table-condensed">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Tipo</th>
                                        <th>OS</th>
                                        <th>Alerta</th>
                                        <th>Data/Hora</th>
                                        <th>Tratamento</th>
                                        <th class="text-right">Opções</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @forelse($alerts as $alert)
                                        <tr>
                                            <td>{{$alert->id}}</td>
                                            <td>{{$alert->types()}}</td>
                                            <td>{{$alert->occurrence_id}}</td>
                                            <td>{{$alert->detail}}</td>
                                            <td>{{$alert->created_at()}}</td>
                                            <td>{{$alert->treated_detail ? "Tratado" : "Não tratado"}}</td>
                                            <td >
                                                <div class="d-flex justify-content-end">
                                                    @if($alert->occurrence)
                                                        <a class="btn btn-sm btn-success" href="{{route("occurrences.show", $alert->occurrence->uuid)}}">OS</a>
                                                    @endif
                                                    <a href="{{route("alerts.show_document", $alert->uuid)}}" class="btn btn-icon btn-sm btn-primary ml-1" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <h3 class="text-center alert alert-info">Sem alertas</h3>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                            {!! $alerts->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
