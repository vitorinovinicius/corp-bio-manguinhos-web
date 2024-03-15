@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">

@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas x Ocorrências</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Empresas x Ocorrências</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('contractor_occurrence_types.create')
        <a class="btn btn-success pull-right" href="{{ route('contractor_occurrence_types.create') }}"><i class="bx bx-plus"></i> Criar</a>
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
                <div class="card-content collapse {{app('request')->exists('contractor_id') == false ? "" : "show"}}">
                    <div class="card-body">
                        <form class="form form-vertical" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empresa</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a empresa">
                                                <option></option>
                                                @forelse($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo de Ocorrência</label>
                                            <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione a OS">
                                                <option></option>
                                                @foreach($occurrence_types as $occurrence_type)
                                                    <option value="{{$occurrence_type->id}}" {{(app('request')->input('occurrence_type_id')==$occurrence_type->id?"selected":"")}}>{{$occurrence_type->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
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
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Empresas x Ocorrências</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($contractor_occurrence_types->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Empresa</th>
                                        <th>Tipo de Ocorrência</th>
                                        <th>Capacidade diária</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($contractor_occurrence_types as $contractor_occurrence_type)
                                        <tr>
                                            <td>{{$contractor_occurrence_type->id}}</td>
                                            <td>{{optional($contractor_occurrence_type->contractor)->name}}</td>
                                            <td>{{optional($contractor_occurrence_type->occurrence_type)->name}}</td>
                                            <td>{{$contractor_occurrence_type->capacity}}</td>
                                            <td class="text-right">
                                                @shield('contractor_occurrence_type.show')
                                                <a href="{{ route('contractor_occurrence_types.show', $contractor_occurrence_type->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('contractor_occurrence_type.edit')
                                                <a href="{{ route('contractor_occurrence_types.edit', $contractor_occurrence_type->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('contractor_occurrence_type.destroy')
                                                <form action="{{ route('contractor_occurrence_types.destroy', $contractor_occurrence_type->uuid) }}"
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
                            {!! $contractor_occurrence_types->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts2')
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
