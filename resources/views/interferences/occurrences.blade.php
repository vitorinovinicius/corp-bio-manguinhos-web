@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Interferências / Exibir #{{$interference->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Interferências</li>
                        <li class="breadcrumb-item active">Relatório de Interferências</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')

    @include('messages')
    @include('error')
    @include('interferences.filter_occurrences')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da Interferência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Descrição</label>
                                    <p class="form-control-static" >{{$interference->description}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static" >{{$interference->status()}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Quantidade</label>
                                    <p class="form-control-static" >{{$occurrences->count()}}</p>
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
                    <h3 class="box-title">Ocorrências com essa interferência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($occurrences->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nº OS</th>
                                        @is('superuser')<th>Empreiteira</th>@endis
                                        <th>Cliente</th>
                                        <th>Qtd da Interferência</th>
                                        <th class="visible-lg">Bairro</th>
                                        <th class="visible-lg">Município</th>
                                        <th>Operador</th>
                                        <th>Data de agendamento</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($occurrences as $occurrence)
                                        <tr>
                                            <td>{{$occurrence->id}}</td>
                                            <td>{{$occurrence->numero_os}}</td>
                                            @is('superuser')<td>{{optional($occurrence->contractor)->name}}</td>@endis
                                            <td>@if(isset($occurrence->occurrence_client))<a href="{{route("occurrence_clients.show",$occurrence->occurrence_client->uuid)}}">{{optional($occurrence->occurrence_client)->client_number}} - {{optional($occurrence->occurrence_client)->name}}</a>@endif</td>
                                            <td>{{$occurrence->interferences()->where('interference_id','=',$interference->id)->count()}}</td>
                                            <td class="visible-lg">{{optional($occurrence->occurrence_client)->district}}</td>
                                            <td class="visible-lg">{{optional($occurrence->occurrence_client)->city}}</td>
                                            @if(!empty($occurrence->operator_id))
                                                <td>{!! ($occurrence->operator->status != 1)? "<strike>" : "" !!}{{(empty($occurrence->operator_id)? "" : $occurrence->operator->name)}}{!! ($occurrence->operator->status != 1)? "</strike>" : "" !!}</td>
                                            @else
                                                <td>-</td>
                                            @endif
                                            <td>{{$occurrence->dataAgendamentoFormart()}}</td>
                                            <td class="text-right">
                                                @include('occurrences.includes.options')
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $occurrences->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('occurrences.includes.modal_information')

    <a class="btn btn-primary" href="{{ route('interferences.dashboard',[Request::getQueryString()]) }}"><i class="bx bx-arrow-back"></i> Voltar</a>


@endsection
