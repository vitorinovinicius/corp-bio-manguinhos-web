@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Motivo de Não realizado</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Motivo de Não realizado</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('cancelamento_status.create')
        <a class="btn btn-success pull-right" href="{{ route('cancelamento_statuses.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
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
                                    <label for="id">ID</label>
                                    <input type="text" class="form-control" name="id"
                                           value="{{ app('request')->input('id') }}" autocomplete="off"
                                           placeholder="ID">
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <input type="text" class="form-control" name="name"
                                           value="{{ app('request')->input('name') }}" autocomplete="off"
                                           placeholder="Nome">
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
                    <h3 class="box-title">Motivo de Não realizado</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($cancelamento_statuses->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nome</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($cancelamento_statuses as $cancelamento_status)
                                        <tr>
                                            <td>{{$cancelamento_status->id}}</td>
                                            <td>{{$cancelamento_status->name}}</td>

                                            <td class="text-right">
                                                @shield('cancelamento_status.show')
                                                <a href="{{ route('cancelamento_statuses.show', $cancelamento_status->id) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('cancelamento_status.edit')
                                                <a href="{{ route('cancelamento_statuses.edit', $cancelamento_status->id) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('cancelamento_status.destroy')
                                                <form action="{{ route('cancelamento_statuses.destroy', $cancelamento_status->id) }}}"
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
                            {!! $cancelamento_statuses->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
