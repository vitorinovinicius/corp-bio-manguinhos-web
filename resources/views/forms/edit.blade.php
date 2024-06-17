@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Editar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
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
            
            <form class="form form-vertical" action="{{ route('forms.store') }}" method="POST" enctype="multipart/form-data">
            @csrf()
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Formulário</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label >Nome do formulário</label>
                                                <input type="text" class="form-control" name="titulo" value="{{ $formulario->descricao }}" placeholder="Insira o nome do relatorio anual">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#storeModal">
                                    <i class="bx bx-down-arrow-alt"></i> Adicionar seção</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            @include('forms.include.add_secao_modal')
        </div>
        <div class="col-md-12">
            <div id="secoes_formulario"></div>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function () {
            $(".select2").select2({
                allowClear: true,
            });
        });

        $(document).ready(function() {
            $('#submitStore').click(function(e) {
                e.preventDefault();

                var csrfToken = $('meta[name="csrf-token"]').attr('content');
                var formularioId = {!! $formulario->id !!};
                $('input[name="formulario_id"]').val(formularioId);

                $.ajax({
                    url: "{{ route('sec_forms.ajax') }}",
                    type: "POST",
                    dataType: "json",
                    data: $('#storeSecao').serialize(),
                    headers: {
                        'X-CSRF-TOKEN': csrfToken
                    },
                    success: function(response) {
                        // Se o status HTTP é 200, considera sucesso
                        $('#storeSecao')[0].reset();
                        $('#storeModal').modal('hide');
                        alert(response.message); // Exibe a mensagem de sucesso
                    },
                    error: function(xhr) {
                        console.log(xhr); // Exibe o objeto de erro no console
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Erro: ' + xhr.responseJSON.message);
                        } else {
                            alert('Erro desconhecido');
                        }
                    }
                });
            });

            
            function carregarSecoes() {
                $.ajax({
                    url: "{{ route('sec_forms.consultar', $formulario->uuid) }}",
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var secoesFormularioDiv = $('#secoes_formulario');
                        secoesFormularioDiv.empty();

                        var secoesMap = {};

                        $.each(response.secoes, function(index, secao) {
                            secoesMap[secao.id] = secao;
                            secoesMap[secao.id].subsecoes = [];
                        });

                        $.each(response.secoes, function(index, secao) {
                            if (secao.secao_id) {
                                secoesMap[secao.secao_id].subsecoes.push(secao);
                            }
                        });

                        function gerarSecaoHtml(secao, indentacao) {
                            var secaoHtml = '<div class="card" style="margin-left: ' + indentacao + 'px;">' +
                                                '<div class="card-header">' +
                                                    '<div class="card-content">' +
                                                        '<div class="card-body">' +
                                                            '<div class="col-12">'+
                                                                '<div class="form-group">'+
                                                                    '<label>Titulo</label>'+
                                                                    '<input type="text" class="form-control" name="descricao" value="'+ secao.descricao +'" placeholder="Digite o limite de caracteres" autocomplete="off">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-12">'+
                                                                '<div class="form-group">'+
                                                                    '<label>Setor</label>'+
                                                                    '<input type="text" class="form-control" name="setor_id" value="'+ secao.setor_nome +'" placeholder="Digite o limite de caracteres" autocomplete="off">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-12">'+
                                                                '<div class="form-group">'+
                                                                    '<label>Usuário</label>'+
                                                                    '<input type="text" class="form-control" name="usuario_id" value="'+ secao.usuario_nome +'" placeholder="Digite o limite de caracteres" autocomplete="off">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-12">'+
                                                                '<div class="form-group">'+
                                                                    '<label>Texto</label>'+
                                                                    '<input type="textarea" class="form-control" name="texto" value="'+ secao.texto +'" placeholder="Digite o limite de caracteres" autocomplete="off">'+
                                                                '</div>'+
                                                            '</div>'+
                                                            '<div class="col-4">'+
                                                                '<div class="form-group">'+
                                                                    '<label>Limite de caracteres</label>'+
                                                                    '<input type="number" class="form-control" name="limite_caracteres" value="'+ secao.limite_caracteres +'" placeholder="Digite o limite de caracteres" autocomplete="off">'+
                                                                '</div>'+
                                                            '</div>';

                            if (secao.subsecoes.length > 0) {
                                $.each(secao.subsecoes, function(index, subsecao) {
                                    secaoHtml += gerarSecaoHtml(subsecao, indentacao + 20); // Incrementar a indentação para subseções
                                });
                            }

                            secaoHtml += '</div>' +
                                        '</div>' +
                                    '</div>' +
                                '</div>';

                            return secaoHtml;
                        }
                        $.each(secoesMap, function(id, secao) {
                            if (!secao.secao_id) { // Só processe as seções principais
                                var secaoHtml = gerarSecaoHtml(secao, 0);
                                secoesFormularioDiv.append(secaoHtml);
                            }
                        });
                    },
                    error: function(xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            alert('Erro: ' + xhr.responseJSON.message);
                        } else {
                            alert('Erro desconhecido');
                        }
                    }
                });
            }

            carregarSecoes();
            $('#submitStore').click(function(e) {
                e.preventDefault();
                carregarSecoes();
            });
        });
        
        document.addEventListener('DOMContentLoaded', function () {
            const radioTitulo = document.getElementById('titulo');
            const radioSubTitulo = document.getElementById('sub-titulo');
            const vinculoTituloSubtitulo = document.getElementById('titulo-selection'); // Corrigi o id para corresponder ao seu HTML
            const existingTitulos = document.getElementById('existing-titulos');

            // Função para verificar se há títulos ou subtítulos existentes
            function checkTitulosSubtitulos() {
                if (existingTitulos.options.length > 1) { // Mais de uma opção (incluindo o placeholder)
                    vinculoTituloSubtitulo.style.display = 'block';
                } else {
                    alert('Não há títulos ou subtítulos disponíveis. Por favor, adicione um título primeiro.');
                    radioTitulo.checked = true;
                    radioSubTitulo.checked = false;
                    vinculoTituloSubtitulo.style.display = 'none';
                }
            }

            // Evento quando "Sub-titulo" é selecionado
            radioSubTitulo.addEventListener('change', function () {
                if (this.checked) {
                    checkTitulosSubtitulos();
                }
            });

            // Evento quando "Titulo" é selecionado
            radioTitulo.addEventListener('change', function () {
                if (this.checked) {
                    vinculoTituloSubtitulo.style.display = 'none';
                }
            });

            // Inicialização da verificação de títulos e subtítulos no carregamento da página
            if (radioSubTitulo.checked) {
                checkTitulosSubtitulos();
            }
        });
        
    </script>

@endsection
