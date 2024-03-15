@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Tipos de despesas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Tipos de despesas</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('expense_type.create')
        <a class="btn btn-success pull-right" href="{{ route('expense_types.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
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
                <div class="card-content collapse {{app('request')->exists('name') == false ? "" : "show" }}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-1">
                                        <div class="form-group">
                                            <label>ID</label>
                                            <input class="form-control" type="text" name="id" placeholder="ID" value="{{ app('request')->input('id') }}">
                                        </div>
                                    </div>
                                    @is('superuses')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" required data-placeholder="Selecione uma empreiteira" required>
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Despesa</label>
                                            <input class="form-control" type="text" name="name" placeholder="despesa" value="{{ app('request')->input('name') }}">
                                        </div>
                                    </div>
                                    <div>
                                        <br>
                                        <button type="submit" class="btn btn-primary pull-righ" id="btn-external-filter">Aplicar</button>
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Tipos de despesa</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($expenseTypes->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        @is('superuser')<th>Empresa</th>@endis
                                        <th>Dispesa</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($expenseTypes as $expenseType)
                                        <tr>
                                            <td>{{$expenseType->id}}</td>
                                            @is('superuser')<td>{{optional($expenseType->contractor)->name}}</td>@endis
                                            <td>{{$expenseType->name}}</td>
                                            <td class="text-right">
                                                @shield('expense_type.show')
                                                <a href="{{ route('expense_types.show', $expenseType->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield

                                                @if($expenseType->contractor_id || \Defender::hasRole("superuser"))
                                                    @shield('expense_type.edit')
                                                    <a href="{{ route('expense_types.edit', $expenseType->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" title="Editar"><i class="bx bx-pencil"></i></a>
                                                    @endshield
                                                    @shield('expense_type.destroy')
                                                    <form action="{{ route('expense_types.destroy', $expenseType->uuid) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" title="Deletar">
                                                            <i class="bx bx-trash"></i></button>
                                                    </form>
                                                    @endshield
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
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
    <!-- Select2 -->
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });
    </script>
@endsection
