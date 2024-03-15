@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Plano de manutenção / Editar #{{$planOccurrence->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Plano de manutenção</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Editar plano de manutenção</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('plan_occurrences.update', $planOccurrence->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    @is('superuser')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select name="contractor_id" class="form-control select2" id="contractor">
                                                <option></option>
                                                @foreach ($contractors as $contractor)
                                                    <option value="{{$contractor->id}}" @if($planOccurrence->contractor_id == $contractor->id) selected @endif> {{$contractor->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo de OS</label>
                                            <select class="form-control select2" name="occurrence_type_id" id="occurrence_type_id" data-placeholder="Técnico">
                                                <option></option>
                                                @if($occurrenceTypes)
                                                    @foreach ($occurrenceTypes as $type)
                                                        <option value="{{$type->id}}" {{($planOccurrence->occurrence_type_id == $type->id?"selected":"")}}>{{$type->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select class="form-control select2" name="occurrence_client_id" id="occurrence_client_id">
                                                <option></option>
                                                @if($occurrenceClients)
                                                    @foreach ($occurrenceClients as $client)
                                                        <option value="{{$client->id}}" {{($planOccurrence->occurrence_client_id == $client->id?"selected":"")}}>{{$client->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select class="form-control select2" name="operator_id" id="operator_id">
                                                <option></option>
                                                @if($operators)
                                                    @foreach ($operators as $operator)
                                                        <option value="{{$operator->id}}" {{($planOccurrence->operator_id == $operator->id?"selected":"")}}>{{$operator->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label for="name">Periodicidade</label>
                                            <input type="number" class="form-control" id="schedule" name="schedule" value="{{ $planOccurrence->schedule }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Data Inicio</label>
                                            <input class="form-control" type="date" name="date_begin" placeholder="document_date" value="{{ $planOccurrence->date_begin }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Data Término</label>
                                            <input class="form-control" type="date" name="date_finish" placeholder="document_date" value="{{ $planOccurrence->date_finish }}">
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <br>
                                        <div class="checkbox checkbox-primary">
                                            <input type="checkbox" name="weekend" id="colorCheckbox1" value="1" {{ ($planOccurrence->weekend ==1 ? "checked" : "") }}>
                                            <label for="colorCheckbox1">Final de semana</label>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" id="status">
                                                <option></option>
                                                <option value=1 {{($planOccurrence->status == 1 ?"selected":"")}}>Ativo</option>
                                                <option value=0 {{($planOccurrence->status == 0 ?"selected":"")}}>Inativo</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-between">
                                        <a class="btn btn-link pull-right"
                                        href="{{ route('plan_occurrences.index') }}"><i
                                             class="bx bx-arrow-back"></i> Voltar</a>
                                        <button type="submit" class="btn btn-primary">Salvar</button>

                                    </div>
                                </div>
                            </div>
                        </form>
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
