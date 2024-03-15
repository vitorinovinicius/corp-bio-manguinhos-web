@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection
@section('header')
    <div class="page-header clearfix">
        <h2>
            Equipamentos
            @shield('equipment.create')
            <a class="btn btn-success pull-right" href="{{ route('equipments.create') }}"><i class="bx bx-plus"></i> Novo</a>
            @endshield
        </h2>
    </div>
@endsection
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Empresas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('equipment.create')
        <a class="btn btn-success pull-right" href="{{ route('equipments.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
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
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ app('request')->input('name') }}" autocomplete="off"
                                           placeholder="Nome">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="type">Tipo</label>
                                    <input type="text" class="form-control" name="type"
                                           value="{{ app('request')->input('type') }}" autocomplete="off"
                                           placeholder="Tipo">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="validade">Validade</label>
                                    <input type="text" class="form-control" name="validade"
                                           value="{{ app('request')->input('validade') }}" autocomplete="off"
                                           placeholder="validade">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="district">Status</label>
                                    <select class="form-control select2" name="status" placeholder="Selecione o status do equipamento">
                                        <option></option>
                                        <option value="1">Ativo</option>
                                        <option value="2">Inativo</option>
                                        <option value="3">Reparo</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-12">
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Equipamentos ({{$equipments->count()}})</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($equipments->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>
                                        <th>Tipo</th>
                                        <th>Validade</th>
                                        <th>Técnico</th>
                                        <th>Status</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($equipments as $equipment)
                                        <tr>
                                            <td>{{$equipment->id}}</td>
                                            <td>{{$equipment->name}}</a></td>
                                            <td>{{$equipment->type}}</td>
                                            <td>{{$equipment->validade}}</td>
                                            <td>{{optional($equipment->user)->name}}</td>
                                            <td>{{$equipment->status()}}</td>

                                            <td class="text-right">
                                                @shield('equipment.show')
                                                <a href="{{ route('equipments.show', $equipment->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('equipment.edit')
                                                <a href="{{ route('equipments.edit', $equipment->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('equipment.destroy')
                                                <form action="{{ route('equipments.destroy', $equipment->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>

                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section('scripts')
@endsection
