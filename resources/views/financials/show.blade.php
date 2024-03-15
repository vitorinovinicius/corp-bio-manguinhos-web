@extends('layouts.frest_template')


@section('content-header')
    <div class="content-header-left col-7 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Conclusão - Liberação / Exibir
                    #{{$financial->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Conclusão - Liberação</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-5 d-flex justify-content-end align-items-center">
        <a class="btn btn-success" href="{{ route('occurrences.show', $financial->occurrence->uuid) }}"><i
                class="bx bx-fast-forward"></i> Voltar para OS</a>
        @shield('financial.edit')
        <a class="btn btn-warning btn-group" role="group" href="{{ route('financials.edit', $financial->uuid) }}"><i
                class="bx bx-pencil"></i> Editar / Fechar</a>
        @endshield
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Conclusão - Liberação</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="name">ID OS interno</label>
                                    <p class="form-control-static">{{$financial->occurrence->id}}</p>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="name">Nº OS interna </label>
                                    <p class="form-control-static">{{optional($financial->occurrence)->numero_os}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Usuário</label>
                                    <p class="form-control-static">{{ optional($financial->user)->name }}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Status</label>
                                    <h3 class="">
                                        <span class='btn btn-sm {{$financial->statusLabel()}}'>{{$financial->status()}}</span>
                                    </h3>
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <label for="name">Data</label>
                                    <p class="form-control-static">{{ $financial->data_approved() }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Mensagem</label>
                                    <p class="form-control-static">{!! $financial->message !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @if($financial->financial_communications->count())
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Comunicações</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            @foreach($financial->financial_communications as $financial_communication)
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="name">ID</label>
                                            <p class="form-control-static">{{$financial_communication->id}}</p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="name">Usuário</label>
                                            <p class="form-control-static">{{ optional($financial_communication->user)->name }}</p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="name">Status</label>
                                            <p class="form-control-static">{{ $financial_communication->status() }}</p>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="name">Criado</label>
                                            <p class="form-control-static">{{ $financial_communication->created_at() }}</p>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Anexo</label>
                                            @if($financial_communication->anexo)
                                                <p class="form-control-static">
                                                    <a href="{{$financial_communication->anexo}}" target="_blank"
                                                       class="btn btn-sm btn-success"><i class="bx bx-download"></i>
                                                        Download</a> -
                                                    <strong>{{ $financial_communication->anexo_name}} </strong>
                                                </p>
                                            @else
                                                <p class="form-control-static">Inexistente</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Mensagem</label>
                                            <p class="form-control-static">{!! $financial_communication->message !!}</p>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <div class="col-12 d-flex justify-content-end">
        <a class="btn btn-primary pull-right" href="{{ route('financial_communications.create', $financial->uuid) }}"><i
                class="bx bx-plus"></i> Adicionar comunicação Empresa</a>
        <a class="btn btn-link" href="{{ route('financials.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    </div>

@endsection
