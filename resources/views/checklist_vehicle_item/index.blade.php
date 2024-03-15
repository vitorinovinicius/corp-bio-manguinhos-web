@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Itens checklist de veículos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Itens checklist de veículos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('vehicles.create')
        <a class="btn btn-success pull-right" href="{{ route('checklist_vechicle_itens.create') }}"><i class="bx bx-plus"></i> Novo</a>
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
                <div class="card-content collapse {{app('request')->exists('name') == false ? "collapsed-box" : ""}}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="get">
                            <div class="form-body">
                                <div class="row">
                                    <div class="form-group col-md-2">
                                        <div>ID</div>
                                        <input class="form-control" type="text" name="id" placeholder="ID" value="{{ app('request')->input('id') }}">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <div>Descrição</div>
                                        <input class="form-control" type="text" name="descricao" placeholder="Descrição" value="{{ app('request')->input('descricao') }}">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <div>Tipo</div>
                                        <div>
                                            <select class="form-control select2" name="type_id" required data-placeholder="Selecione tipo de veículo" required>
                                                <option></option>
                                                @foreach(tipoChecklistVehicles() as $key=>$type)
                                                    <option value="{{$key}}">{{$type}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <br>
                                        <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
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
                    <h3 class="box-title">Itens checklist</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($checklistVehicleItens->count())
                    <table class="table table-condensed table-striped table-sm table-hover">
                        <thead>
                        <tr>
                            <th>ID</th>
                            @is('superuser')
                                <th>Empreiteira</th>
                            @endis
                            <th>Descrição</th>
                            <th>Tipo</th>
                            <th class="text-right">OPÇÕES</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($checklistVehicleItens as $checklistVehicleItem)
                            <tr>
                                <td>{{$checklistVehicleItem->id}}</td>
                                @is('superuser')
                                    <td>{{optional($checklistVehicleItem->contractor)->name}}</td>
                                @endis
                                <td>{{$checklistVehicleItem->descricao}}</td>
                                <td>{{$checklistVehicleItem->typeName()}}</td>
                                <td>
                                    @shield('vehicles.show')
                                    <a class="btn btn-icon btn-sm btn-primary" href="{{ route('checklist_vechicle_itens.show', $checklistVehicleItem->uuid) }}" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                    @endshield
                                    @shield('vehicles.edit')
                                    <a class="btn btn-icon btn-sm btn-warning" href="{{ route('checklist_vechicle_itens.edit', $checklistVehicleItem->uuid) }}" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                    @endshield
                                    @shield('vehicles.destroy')
                                    <form action="{{ route('checklist_vechicle_itens.destroy', $checklistVehicleItem->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
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
