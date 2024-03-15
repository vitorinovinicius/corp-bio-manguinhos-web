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
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('interferences.destroy', $interference->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('interferences.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{route('interferences.edit', $interference->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('interferences.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da Interferência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Descrição</label>
                                    <p class="form-control-static" >{{$interference->description}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <p class="form-control-static" >{{$interference->status()}}</p>
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
                    <h3 class="box-title">Relatório da Interferência</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($interference->occurrences->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped  table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nº OS</th>
                                        <th>Status</th>
                                        @is('superuser')<th>Empreiteira</th>@endis
                                        <th>N. Cliente</th>
                                        <th>Cliente</th>
                                        <th class="visible-lg">Bairro</th>
                                        <th class="visible-lg">Município</th>
                                        <th>Operador</th>
                                        <th>Data de agendamento</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($interference->occurrences as $occurrence)
                                        <tr>
                                            <td>{{$occurrence->id}}</td>
                                            <td>{{$occurrence->numero_os}}</td>
                                            <td>{{$occurrence->getStatus()}}</td>
                                            @is('superuser')<td>{{optional($occurrence->contractor)->name}}</td>@endis
                                            <td><a href="{{route("occurrence_clients.show",$occurrence->occurrence_client->uuid)}}">{{optional($occurrence->occurrence_client)->client_number}}</a></td>
                                            <td><a href="{{route("occurrence_clients.show",$occurrence->occurrence_client->uuid)}}">{{optional($occurrence->occurrence_client)->name}}</a></td>
                                            <td class="visible-lg">{{$occurrence->occurrence_client->district}}</td>
                                            <td class="visible-lg">{{$occurrence->occurrence_client->city}}</td>
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
                            {{--{!! $interferences->render() !!}--}}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if(strpos(URL::previous(), route('interferences.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('interferences.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif


@endsection
