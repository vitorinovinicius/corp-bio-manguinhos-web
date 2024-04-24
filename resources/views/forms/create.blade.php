@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
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

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Criar Formulário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('forms.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="type" value="1">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label>Titulo</label>
                                            <input type="text" class="form-control" name="titulo" value="{{ old('titulo') }}" placeholder="Titulo" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Limite de caracteres</label>
                                            <input type="number" class="form-control" name="limite_caracteres_titulo" value="{{ old('limite_caractere') }}" placeholder="Digite o limite de caracteres" autocomplete="off" required>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="divImagemTitulo">
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-primary" id="addImagemTitulo"><i class="bx bx-plus"></i> Imagem</a>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="divSubTitulo">
                                </div>
                                
                                <div class="row">
                                    <div class="col-3">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-info" id="addSubtitulo"><i class="bx bx-plus"></i> Sub-titulo</a>
                                        </div>
                                    </div>  
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Setor responsável</label>
                                            <select class="form-control select2" name="setor_id"  data-placeholder="Setor responsável pelo preenchimento">
                                                @foreach($teams as $setor)
                                                <option value="{{$setor->id}}">{{$setor->name}}</option>
                                                @endforeach
                                                {{-- <option value="1" {{(old('setor') == 1 ? "selected":"")}}>Recursos Humanos</option>
                                                <option value="0" {{(old('setor') == "0" ? "selected":"")}}>Departamento Pessoal</option> --}}
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('forms.index') }}"><i
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
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
            $(document).on("click", "#addSubtitulo", function (e) {
                e.preventDefault();
                $('<div class="row">' +
                    '<div class="col-6">' +
                        '<div class="form-group">' +
                            '<label for="sub-titulo">Sub-titulo</label>' +
                            '<input type="text" class="form-control" name="sub_titulos[]" value="{{ old('sub_titulos[]') }}" placeholder="Sub-titulo" autocomplete="off">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-3">' +
                        '<div class="form-group">' +
                            '<label for="limite_caracteres">Limite de caracteres</label>' +
                            '<input type="number" class="form-control" name="limite_caracteres_subtitulo[]" value="{{ old('limite_caracteres_subtitulo[]') }}" placeholder="Digite o limite de caracteres" autocomplete="off" required>' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-2">' +
                        '<div class="form-group">' +
                            '<a href="javascript:void(0);" class="btn btn-primary" id="addImagemSubTitulo"><i class="bx bx-plus"></i> Imagem</a>'+
                            '<i class="bx bx-trash remove-row" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                        '</div>' +
                    '</div>' +
                '</div>'+
                '<div class="divImagemSubTitulo"></div>').appendTo(".divSubTitulo");
                return false;
            });
            $(document).on("click", ".remove-row", function () {
                $(this).parent().parent().parent().remove();
            });
        });
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
            $(document).on("click", "#addImagemTitulo", function (e) {
                e.preventDefault();
                $('<div class="row">' +
                    '<div class="col-11">' +
                        '<div class="form-group">' +
                            '<label for="imagem">Selecione uma imagem (JPG, JPEG, PNG):</label>'+
                            '<input type="file" class="form-control" id="imagemTitulo" name="imagemTitulo" accept="image/png, image/jpeg" >'+
                            '<i class="bx bx-trash remove-row-titulo" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                        '</div>' +
                    '</div>' +
                '</div>').appendTo(".divImagemTitulo");
        return false;
            });
            $(document).on("click", ".remove-row-titulo", function () {
                $(this).parent().parent().parent().remove();
            });
        });
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });
            $(document).on("click", "#addImagemSubTitulo", function (e) {
                e.preventDefault();
                $('<div class="row">' +
                    '<div class="col-11">' +
                        '<div class="form-group">' +
                            '<label for="imagem">Selecione uma imagem (JPG, JPEG, PNG):</label>'+
                            '<input type="file" class="form-control" id="imagemSubTitulo" name="imagemSubTitulo" accept="image/png, image/jpeg" >'+
                            '<i class="bx bx-trash remove-row-titulo" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                        '</div>' +
                    '</div>' +
                '</div>').appendTo(".divImagemSubTitulo");
        return false;
            });
            $(document).on("click", ".remove-row-sub-titulo", function () {
                $(this).parent().parent().parent().remove();
            });
        });       
    </script>

@endsection
