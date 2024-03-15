@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Conclusão - Interação de liberação do orçamento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Conclusão</li>
                        <li class="breadcrumb-item active">Interação de liberação do orçamento</li>
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
                <div class="card-content collapse {{ app('request')->exists('numero_os') == false ? "" : "show"}}">
                    <div class="card-body">
                        <form class="form form-vertical" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">ID OS CS</label>
                                            <input class="form-control" id="id" name="id" value="{{ app('request')->input('id') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">Número OS</label>
                                            <input class="form-control" id="numero_os" name="numero_os" value="{{ app('request')->input('numero_os') }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">Status</label>
                                            <select class="form-control" name="status" data-placeholder="Status">
                                                <option value=""></option>
                                                @forelse(FinancialstatusList() as $key=>$value)
                                                    <option value="{{$key}}" {{(app('request')->input('status')=="$key" ? "selected":"")}}>{{$value}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-3">
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
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Listagem dos itens</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($financials->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID OS CS</th>
                                        <th>ID OS Interna</th>
                                        <th>Usuário</th>
                                        <th>Status</th>
                                        <th>Data de aprovação</th>
                                        <th>Data de criação</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($financials as $financial)
                                        <tr>
                                            <td>{{optional($financial->occurrence)->id}}</td>
                                            <td>{{optional($financial->occurrence)->numero_os}}</td>
                                            <td>{{optional($financial->user)->name}}</td>
                                            <td>{{$financial->status()}}</td>
                                            <td>{{$financial->data_approved()}}</td>
                                            <td>{{$financial->created_at()}}</td>
                                            <td class="text-right">
                                                @if($financial->occurrence)
                                                    <a class="btn btn-xs btn-success" href="{{ route('occurrences.show', $financial->occurrence->uuid) }}"><i class="bx bx-fast-forward"></i> Ir para OS</a>
                                                @endif
                                                @shield('financial.show')
                                                <a href="{{ route('financials.show', $financial->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('financial.edit')
                                                <a href="{{ route('financials.edit', $financial->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $financials->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
