@extends('layouts.frest_template')

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Veículo / Exibir #{{$vehicle->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Veículo</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('vehicles.destroy', $vehicle->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('vehicles.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{route('vehicles.edit', $vehicle->uuid)}}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('vehicles.destroy')
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
                    <h3 class="box-title">Dados do veículo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label>Empreiteira</label>
                                    <p class="form-control-static" >{{$vehicle->contractor->name}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Ano do veículo</label>
                                    <p class="form-control-static" >{{$vehicle->year}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data de emissão (Doc.)</label>
                                    <p class="form-control-static" >{{$vehicle->document_date}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Data de vencimento (Doc.)</label>
                                    <p class="form-control-static" >{{$vehicle->due_date}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Placa</label>
                                    <p class="form-control-static" >{{$vehicle->placa}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Chassi</label>
                                    <p class="form-control-static" >{{$vehicle->chassi}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Marca</label>
                                    <p class="form-control-static" >{{$vehicle->brand}}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Modelo</label>
                                    <p class="form-control-static" >{{$vehicle->model}}</p>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="form-group">
                                    <label>Tipo</label>
                                    <p class="form-control-static" >{{$vehicle->types()}}</p>
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
                    <h3 class="box-title">Imagens do veículo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            @forelse($vehicle->archives as $fotos)
                                <div class="col-2 text-center">
                                    <img src="{{$fotos->url}}" alt="" class="img-responsive">
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <p class="form-control-static" >Não há mais imagens</p>
                                </div>
                            @endforelse
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
                    <h3 class="box-title">Checklists do Veículo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($vehicle->checklist_vehicle_basics->count())
                            <div class="table-responsive">
                                <table class="table table-condensed table-striped table-sm table-hover">
                                    <thead>
                                    <tr>
                                        <th>ID</th>
                                        @if(!Auth::user()->contractor_id)
                                            <th>Empresa</th>
                                        @endif
                                        <th>Avaliador</th>
                                        <th>Condutor</th>
                                        <th>Tipo Veículo</th>
                                        <th>Placa</th>
                                        <th>Data ínicio</th>
                                        <th>Data fim</th>
                                        <th>Recebido no servidor</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($vehicle->checklist_vehicle_basics()->orderBy("id","desc")->get() as $vehicleChecklistBasic)
                                        <tr>
                                            <td>{{$vehicleChecklistBasic->id}}</td>
                                            @if(!Auth::user()->contractor_id)
                                                <td>{{$vehicleChecklistBasic->contractor->name}}</td>
                                            @endif
                                            <td>{{$vehicleChecklistBasic->avaliador}}</td>
                                            <td>{{$vehicleChecklistBasic->condutor->name}}</td>
                                            <td>{{tipoVeiculo($vehicleChecklistBasic->type_id)}}</td>
                                            <td>{{$vehicleChecklistBasic->placa}}</td>
                                            <td>@if($vehicleChecklistBasic->check_in_date) {{\Carbon\Carbon::parse($vehicleChecklistBasic->check_in_date)->format("d/m/Y H:i:s")}} @endif</td>
                                            <td>@if($vehicleChecklistBasic->finish_date) {{\Carbon\Carbon::parse($vehicleChecklistBasic->finish_date)->format("d/m/Y H:i:s")}} @endif</td>
                                            <td>{{\Carbon\Carbon::parse($vehicleChecklistBasic->created_at)->format("d/m/Y H:i:s")}}</td>
                                            <td class="text-right">
                                                @shield('vehicles.checklist')
                                                <a href="{{ route('vehicles.checklist.show', $vehicleChecklistBasic->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                <a href="{{ route('vehicles.checklist.checklistPdf', [$vehicleChecklistBasic->uuid]) }}" class="btn btn-icon btn-sm btn-warning" data-toggle="tooltip" data-placement="left" title="PDF" target="_blank"><i class="bx bxs-file-pdf"></i></a>
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


    @if(strpos(URL::previous(), route('vehicles.index')) !== false)
        <a class="btn btn-primary" href="{{ URL::previous() }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @else
        <a class="btn btn-primary" href="{{ route('vehicles.index') }}"><i class="bx bx-arrow-back"></i> Voltar</a>
    @endif

@endsection
