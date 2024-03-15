@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Item checklist de veículos / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Item checklist veículos</li>
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
                    <h3 class="box-title">Dados do Item</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form action="{{ route('checklist_vechicle_itens.store') }}" method="POST" enctype="multipart/form-data">
                            <div class="form-body">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
                                <div class="row">
                                    <div class="form-group col-md-4" {{ $errors->has('descricao') ? ' has-error' : '' }}>
                                        <label for="year">Descrição</label>
                                        <input type="text" class="form-control" id="descricao" name="descricao" value="{{ old('descricao') }}" placeholder="Descrição">
                                    </div>
                                    <div class="form-group col-md-4" {{ $errors->has('type') ? ' has-error' : '' }}>
                                        <label for="">Tipo</label>
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
                            </div>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Criar</button>
                                    <a class="btn btn-link pull-right"
                                       href="{{ route('checklist_vechicle_itens.index') }}"><i
                                            class="bx bx-arrow-back"></i> Voltar</a>
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

        });

    </script>
    {{--BUSCA CEP--}}
    @include('helpers.busca_cep_helper')
@endsection
