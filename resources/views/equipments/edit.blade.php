@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">

@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Equipamento / Editar #{{$equipment->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Equipamentos</li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    <h3 class="box-title">Editar Equipamento - #{{$equipment->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('equipments.update', $equipment->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" id="name" class="form-control" name="name" value="{{$equipment->name}}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="type">Tipo</label>
                                            <input type="text" class="form-control" id="type" name="type" value="{{ (old('type'))? old('type') : $equipment->type}}" placeholder="Tipo" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="Validade">Validade</label>
                                            <input type="text" class="form-control date-picker" name="validade" value="{{ (old('validade'))? old('validade') : $equipment->validade}}" placeholder="Validade" autocomplte="off" >
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control select2" name="status" placeholder="Selecione o status do equipamento">
                                                <option></option>
                                                <option value="1" @if($equipment->status == 1) SELECTED @endif >Ativo</option>
                                                <option value="2" @if($equipment->status == 2) SELECTED @endif >Inativo</option>
                                                <option value="3" @if($equipment->status == 3) SELECTED @endif >Reparo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="user">Técnico</label>
                                            <select class="form-control select2" name="user_id" data-placeholder="Técnico">
                                                <option>Não vinculado</option>
                                                @foreach ($operators as $operator)
                                                <option value="{{$operator->id}}" @if($equipment->user_id == $operator->id) SELECTED @endif>{{$operator->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('equipments.index') }}"><i
                                                class="bx bx-arrow-back"></i> Voltar</a>
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
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione um supervisor",
                allowClear: true
            });

            $('.date-picker').pickadate({
                formatSubmit: 'dd/mm/yyyy',
                monthsFull: [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                monthsShort: [
                    "Jan",
                    "Fev",
                    "Mar",
                    "Abr",
                    "Ma",
                    "Jun",
                    "Jul",
                    "Agos",
                    "Set",
                    "Out",
                    "Nov",
                    "Dez"
                ],
                weekdaysShort: [
                    "D",
                    "S",
                    "T",
                    "Q",
                    "Q",
                    "S",
                    "S"
                ],
                today: 'Hoje',
                clear: 'Limpar',
                close: 'Fechar',
            });
        });
    </script>
@endsection
