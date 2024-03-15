@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Veículos / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Veículos</li>
                        <li class="breadcrumb-item active">Criar</li>
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
                    <h3 class="box-title">Criar Veículo</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Ano do veículo</label>
                                            <input type="text" class="form-control" id="year" name="year" value="{{ old('year') }}" placeholder="Ano do veículo">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Data de emissão (Doc.)</label>
                                            <input type="date" class="form-control" id="document_date" name="document_date" value="{{ old('document_date') }}" placeholder="Data emissão documento">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Data de vencimento (Doc.)</label>
                                            <input type="date" class="form-control" id="due_date" name="due_date" value="{{ old('due_date') }}" placeholder="Data vencimento documento ">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Placa</label>
                                            <input type="text" class="form-control" id="placa" name="placa" value="{{ old('placa') }}" placeholder="Nº da placa">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Chassi</label>
                                            <input type="text" class="form-control" id="chassi" name="chassi" value="{{ old('chassi') }}" placeholder="Nº do chassi">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Marca</label>
                                            <input type="text" class="form-control" id="brand" name="brand" value="{{ old('marca') }}" placeholder="Marca">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Modelo</label>
                                            <input type="text" class="form-control" id="model" name="model" value="{{ old('model') }}" placeholder="Modelo">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Tipo</label>
                                            <select class="form-control select2" name="type" required data-placeholder="Selecione tipo de veículo" required>
                                                <option></option>
                                                @forelse(typeVehicle() as $key=>$type)
                                                    <option value="{{$key}}">{{$type}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label>Fotos</label>
                                            <input type="file" class="form-control" name="archives[]" multiple>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('vehicles.index') }}"><i
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
    <script nonce="{{ csp_nonce() }}">

        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
            $(document).on("click","#addPhone",function (e) {
                e.preventDefault();
                $('<div class="divPhone col-md-12 padding-0 media-middle">'+
                    '<div class="form-group col-md-4">'+
                    '<label for="phone">Telefone</label>'+
                    '<input type="text" class="form-control" name="phones[]" placeholder="Telefone">'+
                    '</div>'+
                    '<div class="form-group col-md-4" >'+
                    '<label for="Obs">Obs</label>'+
                    '<input type="text" class="form-control" name="obs[]" placeholder="Observação">'+
                    '<i class="bx bx-trash-o remove-row" style="position: absolute;right: 0;bottom: 10px;"></i>'+
                    '</div>'+
                    '</div>').appendTo(".divPhonePrincipal");
                return false;
            });
            $(document).on("click",".remove-row",function(){
                $(this).parent().parent().remove();
            });
        });

    </script>
    {{--BUSCA CEP--}}
    @include('helpers.busca_cep_helper')
@endsection
