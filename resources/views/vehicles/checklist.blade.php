@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Checklists de Veículos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Checklists de Veículos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Checklists de Veículos</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($checklist_vehicle_basics->count())
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
                                    @foreach($checklist_vehicle_basics as $vehicleChecklistBasic)
                                        <tr>
                                            <td>{{$vehicleChecklistBasic->id}}</td>
                                            @if(!Auth::user()->contractor_id)
                                                <td>{{optional($vehicleChecklistBasic->contractor)->name}}</td>
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
