@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Plano de manutenção / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Plano de manutenção</li>
                        <li class="breadcrumb-item active">Criar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <form action="{{route('plan_occurrences.store')}}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Adicionar plano</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">

                                @is('superuser')
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Empreiteira</label>
                                        <select name="contractor_id" class="form-control select2" id="contractor_id">
                                            <option></option>
                                            @foreach ($contractors as $contractor)
                                                <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}> {{$contractor->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                @endis

                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Tipo de OS</label>
                                        <select class="form-control select2" name="occurrence_type_id" id="occurrence_type_id" data-placeholder="Tipo de OS">
                                            <option></option>
                                            @if($occurrenceTypes)
                                                @foreach ($occurrenceTypes as $type)
                                                    <option value="{{$type->id}}" {{(app('request')->input('occurrence_type_id')==$type->id?"selected":"")}}>{{$type->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Cliente</label>
                                        <select class="form-control select2" name="occurrence_client_id" id="occurrence_client_id" data-placeholder="Cliente">
                                            <option></option>
                                            @if($occurrenceClients)
                                                @foreach ($occurrenceClients as $client)
                                                    <option value="{{$client->id}}" {{(app('request')->input('occurrence_client_id')==$client->id?"selected":"")}}>{{$client->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group">
                                        <label>Técnico</label>
                                        <select class="form-control select2" name="operator_id" id="operator_id" data-placeholder="Técnico">
                                            <option></option>
                                            @if($operators)
                                                @foreach ($operators as $operator)
                                                    <option value="{{$operator->id}}" {{(app('request')->input('operator_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label for="name">Periodicidade (Dias) <i class="bx bx-message-error" title="Diferença de dias para cada criação de OS" data-toggle="tooltip" data-placement="top"></i></label>
                                        <input type="number" class="form-control" id="schedule" name="schedule" value="{{ app('request')->input('schedule') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Data Inicio</label>
                                        <input class="form-control" type="date" name="date_begin" placeholder="document_date" value="{{ app('request')->input('date_begin') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group">
                                        <label>Data Término</label>
                                        <input class="form-control" type="date" name="date_finish" placeholder="document_date" value="{{ app('request')->input('date_finish') }}">
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group form-check">
                                        <br>
                                        <input type="checkbox" class="form-check-input" id="weekend" name="weekend" value='1'>
                                        <label class="form-check-label">Final de semana</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Criar</button>

            </div>
        </div>
    </form>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
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
