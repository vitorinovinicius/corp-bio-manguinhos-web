@extends('layouts.frest_template')
@section('css')
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/default.css')}}"> --}}
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">
    {{-- <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/default.time.css')}}"> --}}
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
                            @csrf()
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-8">
                                        <div class="form-group">
                                            <label >Nome do relatório</label>
                                            <input type="text" class="form-control" name="descricao_relatorio" value="{{ old('descricao_relatorio') }}" placeholder="Insira o nome do relatorio anual">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label >Ano</label>
                                            <input type="text" id="yearpicker" class="form-control input-small " name="ano" value="{{ old('ano') }}" placeholder="Insira o ano do relatório" readonly>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label >Nome do formulário</label>
                                            <input type="text" class="form-control" name="descricao_formulario" value="{{ old('descricao_formulario') }}" placeholder="Insira o nome do formulário">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link  pull-left" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
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
    {{-- <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script> --}}
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.time.js')}}"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">

        
        $(document).ready(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });

            $('#yearpicker').pickadate({
                monthsShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
                selectDays: false,
                selectYears: true,
                selectMonths: false,
                showMonthsShort: true,
                format: 'yyyy',
                max: new Date().getFullYear() + 5,
                onSet: function(context) {
                    // Evitar que o campo seja limpo ao selecionar um ano
                    if (context.select) {
                        this.close();
                    }
                },
                onClose: function() {
                    // Garantir que o campo seja atualizado com o ano selecionado
                    $('#yearpicker').blur();
                }
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
                            '<label for="add_subtitulo"> </label>' +
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
                    '<div class="col-2">'+
                        '<label for="principal">Tipo de imagem</label>'+
                        '<div class="form-group" >'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemTitulo" value="1" class="form-check-input imagem-checkbox" id="sim_principal" checked>'+
                                '<label class="form-check-label" for="sim_principal">Figura</label>'+                                                        
                            '</div>'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemTitulo" value="2" class="form-check-input imagem-checkbox" id="nao_principal">'+
                                '<label class="form-check-label" for="nao_principal">Gráfico</label>'+                                                        
                            '</div>'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemTitulo" value="3" class="form-check-input imagem-checkbox" id="nao_principal">'+
                                '<label class="form-check-label" for="nao_principal">Tabela</label>'+                                                        
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-9">' +
                        '<div class="form-group">' +
                            '<label for="imagem">Selecione uma imagem (JPG, JPEG, PNG):</label>'+
                            '<input type="file" class="form-control" id="imagemTitulo" name="imagemTitulo" accept="image/png, image/jpeg" >'+
                            '<label for="legendaImagemTitulo">Legenda</label>'+
                            '<input type="text" class="form-control" id="legendaImagemTitulo" name="legendaImagemTitulo">'+
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
                    '<div class="col-2">'+
                        '<label for="principal">Tipo de imagem</label>'+
                        '<div class="form-group" >'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemSubTitulo[]" value="1" class="form-check-input imagem-checkbox" id="sim_principal" checked>'+
                                '<label class="form-check-label" for="sim_principal">Figura</label>'+                                                        
                            '</div>'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemSubTitulo[]" value="2" class="form-check-input imagem-checkbox" id="nao_principal">'+
                                '<label class="form-check-label" for="nao_principal">Gráfico</label>'+                                                        
                            '</div>'+
                            '<div class="form-group form-check form-check-inline">'+
                                '<input type="checkbox" name="checkImagemSubTitulo[]" value="3" class="form-check-input imagem-checkbox" id="nao_principal">'+
                                '<label class="form-check-label" for="nao_principal">Tabela</label>'+                                                        
                            '</div>'+
                        '</div>'+
                    '</div>'+
                    '<div class="col-9">' +
                        '<div class="form-group">' +
                            '<label for="imagem">Selecione uma imagem (JPG, JPEG, PNG):</label>'+
                            '<input type="file" class="form-control" id="imagemSubTitulo" name="imagemSubTitulo" accept="image/png, image/jpeg" >'+
                            '<label for="legendaImagemSubTitulo">Legenda</label>'+
                            '<input type="text" class="form-control" id="legendaImagemSubTitulo" name="legendaImagemSubTitulo[]">'+
                            '<i class="bx bx-trash remove-row-titulo" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                        '</div>' +
                    '</div>' +
                '</div>').appendTo(".divImagemSubTitulo");
                return false;
            });

            $(document).on("click", ".remove-row-sub-titulo", function () {
                $(this).parent().parent().parent().remove();
            });
            $(document).on("click", ".remove-row", function () {
                $(this).closest('.row').remove();
                
                // Garantir que, após a remoção da linha, apenas um checkbox seja marcado em cada bloco
                $('.divImagemSubTitulo .row').each(function() {
                    var $checkboxes = $(this).find('.imagem-checkbox');
                    if ($checkboxes.filter(':checked').length === 0) {
                        $checkboxes.eq(0).prop('checked', true);
                    }
                });
            });

            // Evitar que mais de um checkbox seja marcado em cada bloco
            $(document).on('change', '.imagem-checkbox', function() {
                var $checkboxes = $(this).closest('.row').find('.imagem-checkbox');
                if ($(this).is(':checked')) {
                    $checkboxes.not(this).prop('checked', false);
                }
            });
        });         
        
    </script>

@endsection
