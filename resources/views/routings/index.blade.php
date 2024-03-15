@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Roteirização</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Roteirizações</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">

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
                <div class="card-content collapse {{app('request')->exists('contractor_id') == false ? "" : "show" }}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione uma empreiteira" >
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}" {{((app('request')->input('contractor_id')==$contractor->id) ? "selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select class="form-control select2" name="operator_id" data-placeholder="Selecione um técnico" >
                                                <option></option>
                                                @forelse($operators as $operator)
                                                    <option
                                                        value="{{$operator->id}}" {{((app('request')->input('operator_id')==$operator->id) ? "selected":"")}}>{{$operator->id}}
                                                        - {{$operator->name}} @if($operator->contractor)
                                                            - {{$operator->contractor->name}} @endif</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Data da roteirização</label>
                                            <input class="form-control" type="date" name="routing_date" placeholder="routing_date" value="{{ app('request')->input('routing_date') }}">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col">
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                        <button type="submit" class="btn btn-primary pull-right " id="btn-external-filter">Aplicar</button>
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
                    <h3 class="box-title">Roteirizações</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($routings->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>Empreiteira</th>
                                        <th>Técnico</th>
                                        <th>Tipo de pesquisa</th>
                                        <th>Data da pesquisa</th>
                                        <th>Roteiro Enviado</th>
                                        <th>Roteiro Recebido</th>
                                        {{-- <th class="text-right">OPÇÕES</th> --}}
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($routings as $routing)
                                        <tr>
                                            <td>{{optional($routing->contractor)->name}}</td>
                                            <td>{{optional($routing->operator)->name}}</td>
                                            <td>{{$routing->types()}}</td>
                                            <td>{{$routing->routing_date}}</td>
                                            <td>
                                                @php
                                                    $addresses = json_decode($routing->addresses, true);
                                                @endphp
                                                @foreach ($addresses as $address)
                                                    <div>
                                                        @isset($address['id']) 
                                                            {{$address['id']}} - 
                                                        @endisset  
                                                        {{$address['address']}} </div>
                                                    <hr>
                                                @endforeach

                                            </td>
                                            <td>
                                                @php
                                                    $routedAddresses = json_decode($routing->routed_addresses, true);
                                                @endphp
                                                @foreach ($routedAddresses as $routedAddress)                                                 
                                                    <div>
                                                        @if(isset($routedAddress['id'])) 
                                                            {{$routedAddress['id']}} - {{$routedAddress['address']}} 
                                                        @else
                                                            {{$routedAddress['lat']}}, {{$routedAddress['lng']}} 
                                                         @endif
                                                    </div>
                                                    <hr>
                                                @endforeach

                                            </td>
                                            <td>
                                                {{-- @shield('users.show')
                                                <a href="{{ route('vehicles.show', $vehicle->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                @endshield
                                                @shield('users.edit')
                                                <a href="{{ route('vehicles.edit', $vehicle->uuid) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="Editar"><i class="bx bx-pencil"></i></a>
                                                @endshield
                                                @shield('users.destroy')
                                                <form action="{{ route('vehicles.destroy', $vehicle->uuid) }}"
                                                      method="POST" style="display: inline;"
                                                      onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                    <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" data-placement="left" title="Deletar"><i class="bx bx-trash"></i></button>
                                                </form>
                                                @endshield --}}
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
