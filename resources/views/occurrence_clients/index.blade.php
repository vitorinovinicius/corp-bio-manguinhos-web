@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Clientes</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Clientes</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('occurrence_clients.create')
        <a class="btn btn-success pull-right" href="{{ route('occurrence_clients.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Filtro </h4>
            <a class="heading-elements-toggle">
                <i class="bx bx-dots-vertical font-medium-3"></i>
            </a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li>
                        <a data-action="collapse">
                            <i class="bx bx-chevron-down"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="card-content collapse {{ app('request')->exists('name') == false ? "" : "show"}}">
            <div class="card-body">
                <form class="form form-horizontal" method="get">
                    <div class="form-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" name="id"
                                           value="{{ app('request')->input('id') }}" autocomplete="off"
                                           placeholder="ID">
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="client_number">N° cliente</label>
                                    <input type="text" class="form-control" name="client_number"
                                           value="{{ app('request')->input('client_number') }}" autocomplete="off"
                                           placeholder="N° cliente">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ app('request')->input('name') }}" autocomplete="off"
                                           placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="email">E-mail</label>
                                    <input type="text" class="form-control" name="email"
                                           value="{{ app('request')->input('email') }}" autocomplete="off"
                                           placeholder="E-mail">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="cpf_cnpj">CPF ou CNPJ</label>
                                    <input type="text" class="form-control" name="cpf_cnpj"
                                           value="{{ app('request')->input('cpf_cnpj') }}" autocomplete="off"
                                           placeholder="CPF ou CNPJ">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label for="address">Endereço</label>
                                    <input type="text" class="form-control" name="address"
                                           value="{{ app('request')->input('address') }}" autocomplete="off"
                                           placeholder="Endereço">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="district">Bairro</label>
                                    <input type="text" class="form-control" name="district"
                                           value="{{ app('request')->input('district') }}" autocomplete="off"
                                           placeholder="Bairro">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="city">Cidade</label>
                                    <input type="text" class="form-control" name="city"
                                           value="{{ app('request')->input('city') }}" autocomplete="off"
                                           placeholder="Cidade">
                                </div>
                            </div>
                            <div class="col-2">
                                <div class="form-group">
                                    <br>
                                    <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                    <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12  table-responsive">
                                @if($occurrence_clients->count())
                                    <table class="table table-condensed table-striped table-sm table-hover">
                                        <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>Nº cliente</th>
                                            <th>Nome</th>
                                            <th>Telefone</th>
                                            <th>Bairro</th>
                                            <th>Município</th>
                                            <th>Zona</th>

                                            <th class="text-right">OPÇÕES</th>
                                        </tr>
                                        </thead>

                                        <tbody>
                                        @foreach($occurrence_clients as $occurrence_client)
                                            <tr>
                                                <td>{{$occurrence_client->id}}</td>
                                                <td>{{$occurrence_client->client_number}}</td>
                                                <td>{{$occurrence_client->name}}</td>
                                                <td>{{!empty($occurrence_client->occurrence_client_phones->last()->phone)? $occurrence_client->occurrence_client_phones->last()->phone : "-"}}</td>
                                                <td>{{$occurrence_client->district}}</td>
                                                <td>{{$occurrence_client->city}}</td>
                                                <td>{{optional($occurrence_client->zone)->zone}}</td>


                                                <td class="text-right">
                                                    @shield('occurrence_clients.show')
                                                    <a href="{{ route('occurrence_clients.show', $occurrence_client->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                    @endshield
                                                    @shield('occurrence_clients.edit')
                                                    <a href="{{ route('occurrence_clients.edit', $occurrence_client->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                    @endshield
                                                    @shield('occurrence_clients.destroy')
                                                    <form action="{{ route('occurrence_clients.destroy', $occurrence_client->uuid) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar">
                                                            <i class="bx bx-trash"></i></button>
                                                    </form>
                                                    @endshield
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                    {!! $occurrence_clients->render() !!}
                                @else
                                    <h3 class="text-center alert alert-info">Vazio!</h3>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
