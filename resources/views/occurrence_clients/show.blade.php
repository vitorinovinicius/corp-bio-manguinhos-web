@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Clientes / Exibir #{{$occurrence_client->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Clientes</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('occurrence_clients.destroy', $occurrence_client->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('occurrence_clients.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('occurrence_clients.edit', $occurrence_client->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('occurrence_clients.destroy')
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
                    <h3 class="box-title">Dados do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Nome completo do cliente</label>
                                    <p class="form-control-static">{{$occurrence_client->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">E-mail</label>
                                    <p class="form-control-static">{{$occurrence_client->email}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">CPF ou CNPJ</label>
                                    <p class="form-control-static">{{$occurrence_client->cpf_cnpj}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Número externo do cliente</label>
                                    <p class="form-control-static">{{$occurrence_client->client_number}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">CEP</label>
                                    <p class="form-control-static">{{$occurrence_client->cep}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Telefones</label>
                                    @forelse($occurrence_client->occurrence_client_phones as $phone)
                                        <p class="form-control-static">{{$phone->phone}}</p>
                                    @empty
                                        <p class="form-control-static">Não há telefone associado</p>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Endereço</label>
                                    <p class="form-control-static">{{$occurrence_client->address}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Nº</label>
                                    <p class="form-control-static">{{$occurrence_client->number}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Bairro</label>
                                    <p class="form-control-static">{{$occurrence_client->district}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Cidade</label>
                                    <p class="form-control-static">{{$occurrence_client->city}}</p>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Estado</label>
                                    <p class="form-control-static">{{getToUf($occurrence_client->uf)}}</p>
                                </div>
                            </div>
                            @is('superuser')
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Coordenadas</label>
                                    <p class="form-control-static">{{$occurrence_client->lat}}, {{$occurrence_client->lng}}</p>
                                </div>
                            </div>
                            @endis
                        </div>
                        
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="zone">Zona</label>
                                    <p class="form-control-static">{{optional($occurrence_client->zone)->zone}}</p>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Complemento</label>
                                    <p class="form-control-static">{{$occurrence_client->complement}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Referência</label>
                                    <p class="form-control-static">{{$occurrence_client->reference}}</p>
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
                    <h3 class="box-title">Ocorrências do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12  table-responsive">
                                @if(\Artesaos\Defender\Facades\Defender::hasRole('superuser') || \Artesaos\Defender\Facades\Defender::hasRole('regiao'))
                                    @php
                                        $count = $occurrence_client->occurrences->count();
                                        $foreach = $occurrence_client->occurrences;
                                    @endphp
                                @else
                                    @php
                                        $count = $occurrence_client->occurrences->where('contractor_id','=',optional(Auth::user())->contractor_id)->count();
                                        $foreach = $occurrence_client->occurrences->where('contractor_id','=',optional(Auth::user())->contractor_id);
                                    @endphp
                                @endif

                                @if(isset($occurrence_client->occurrences) && $count > 0)
                                    <table class="table table-condensed table-striped table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Prioridade</th>
                                            <th>Nome OS</th>
                                            <th>Nº OS</th>
                                            <th>Empresa</th>
                                            <th>Atribuído para</th>
                                            <th>Agendado</th>
                                            <th>Realizado</th>
                                            <th>Status</th>

                                            <th class="text-right">OPÇÕES</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($foreach as $occurrence)
                                            <tr>
                                                <td>{{$occurrence->id}}</td>
                                                <td>{{priority_name($occurrence->priority)}}</td>
                                                <td>{{optional($occurrence->occurrence_type)->name}}</td>
                                                <td>{{$occurrence->numero_os}}</td>
                                                <td>{{optional($occurrence->contractor)->name}}</td>
                                                <td>{{(empty($occurrence->operator_id)? "-" : $occurrence->operator->name)}}</td>
                                                <td>{{( empty($occurrence->schedule_date)? "-" : date('d/m/Y', strtotime($occurrence->schedule_date))) }}</td>
                                                <td>{{( empty($occurrence->check_out)? "-" : date('d/m/Y', strtotime($occurrence->check_out))) }}</td>
                                                <td>{{($occurrence->getStatus())}}</td>

                                                <td class="text-right">
                                                    <a class="btn btn-xs btn-primary" href="{{ route('occurrences.show', $occurrence->uuid) }}" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                @else
                                    <h3 class="text-center">Não há OS associadas a esse cliente</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    @if(strpos(URL::previous(), route('occurrence_clients.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('occurrence_clients.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
