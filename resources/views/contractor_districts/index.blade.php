@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas x bairros</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Empresas x bairros</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('contractor_districts.create')
        <a class="btn btn-success pull-right" href="{{ route('contractor_districts.create') }}"><i class="bx bx-plus"></i> Novo</a>
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
                                            <label>Bairro</label>
                                            <select class="form-control select2" name="district_id" data-placeholder="Selecione o Bairro">
                                                <option></option>
                                                @foreach($districts as $district)
                                                    <option value="{{$district->id}}" {{(app('request')->input('district_id')==$district->id?"selected":"")}}>{{$district->name}}</option>
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
                    <h3 class="box-title">Empresas x Bairros</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($contractor_districts->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Empresa</th>
                                        <th>Bairro</th>

                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($contractor_districts as $contractor_district)
                                        <tr>
                                            <td>{{$contractor_district->id}}</td>
                                            <td>{{optional($contractor_district->contractor)->name}}</td>
                                            <td>{{optional($contractor_district->district)->name}}</td>
                                            <td class="text-right">
                                                @shield('contractor_district.show')
                                                <a href="{{ route('contractor_districts.show', $contractor_district->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('contractor_district.edit')
                                                <a href="{{ route('contractor_districts.edit', $contractor_district->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('contractor_district.destroy')
                                                <form action="{{ route('contractor_districts.destroy', $contractor_district->uuid) }}"
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
                            {!! $contractor_districts->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
