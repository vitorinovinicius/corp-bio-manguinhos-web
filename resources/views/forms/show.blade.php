@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-8 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Exibir</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-4 d-flex justify-content-end align-items-center">
        @is(['superuser', 'admin'])
            <form id="relatorio-form" action="{{ route('relatorio.store', $formulario->uuid) }}" method="POST" style="display: inline;">
                @csrf
                @method('POST')
                <div class="btn-group pull-right" role="group" aria-label="...">
                    @if($formulario->status == 2)
                        <button type="button" class="btn btn-icon btn-sm btn-success" id="generate-report-btn"><i class="bx bx-file"></i> Gerar relatório</button>
                    @endif
                </div>
            </form>
        @endis
    </div>
@endsection

@section('content')

    <div class="row">
        <div class="col-12">            
            <div class="d-flex justify-content-end align-items-center">
                @is(['superuser', 'admin'])
                    @if($formulario->status == 0)
                        <a href="javascript:void(0);" onclick="iniciarFormulario('{{ route('forms.inicia_ajax', $formulario->uuid) }}')" class="btn btn-sm btn-info pull-right" data-toggle="tooltip" data-placement="left" title="Iniciar">
                            <i class="bx bx-mail-send"></i> INICIAR FORMULÁRIO
                        </a>
                    @endif
                @endis
            </div>
            <div class="card">
                <div class="card-header">
                    <div class="col-10">
                        <h3 class="box-title">Formulário</h3>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label >Nome do formulário</label>
                                        <p class="form-control-static">{{ $formulario->descricao }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12">
                            <div class="d-flex justify-content-center">
                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#storeModal">
                                    <i class="bx bx-list-plus"></i> Adicionar seção</button>
                            </div>
                        </div>
                    </div>
                </div>
                
                @include('forms.include.add_secao_modal')
            </div>
        </div>
    </div>
    @if($formulario->secoes->count())
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Seções do formulário</h3>
                </div>
                <hr>
                @foreach($formulario->secoes as $secao)
                    <div class="card-header">
                        <h4>Seção #{{$secao->id}}</h4>
                        <div class="smartwizard-container">
                                
                            <div id="smartwizard-{{ $secao->id }}" class="smartwizard_{{$secao->status}}">
                                <ul class="nav">
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-1-{{ $secao->id }}">Pendente</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-2-{{ $secao->id }}">Em andamento</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-3-{{ $secao->id }}">Em análise</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-4-{{ $secao->id }}">Em correção</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="#step-5-{{ $secao->id }}">Concluído</a>
                                    </li>
                                </ul>
                                <div class="tab-content">
                                    <div id="step-1-{{ $secao->id }}" class="tab-pane" role="tabpanel"></div>
                                    <div id="step-2-{{ $secao->id }}" class="tab-pane" role="tabpanel"></div>
                                    <div id="step-3-{{ $secao->id }}" class="tab-pane" role="tabpanel"></div>
                                    <div id="step-4-{{ $secao->id }}" class="tab-pane" role="tabpanel"></div>
                                    <div id="step-5-{{ $secao->id }}" class="tab-pane" role="tabpanel"></div>
                                </div>
                            </div>
                        </div>
                        <div class="btn-group" role="group" aria-label="...">
                            @if($secao->status == 4)
                                <a href="{{ route('sec_forms.status', [$secao->uuid, 6, auth()->user()->uuid]) }}" class="btn btn-sm btn-danger desaprova_status"><i class="bx bxs-dislike"></i> DESAPROVAR</a>
                            @endif
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                @if($secao->status == 2 && $secao->email_status == 1)
                                    <div class="col-12 d-flex justify-content-center">
                                        <p><span class="badge badge-warning"> Aguardando confirmação de e-mail</span></p>
                                    </div>
                                @endif
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Setor</label>
                                        <p class="form-control-static">{{ $secao->setor()->where('id', $secao->setor_id)->pluck('name')->first() ?: '' }}</p>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label for="name">Usuário</label>
                                        <p class="form-control-static">{{ $secao->usuario()->where('id', $secao->user_id)->pluck('name')->first() ?: 'Não designado' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        @if(!$secao->secao_id)
                                            <label for="name">Titulo</label>
                                        @else
                                            <label for="name">Sub-titulo</label>
                                        @endif
                                        <p class="form-control-static">{{ $secao->descricao }}</p>
                                    </div>
                                </div>
                            </div>                        
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="texto1">Texto</label>
                                        <textarea class="form-control" id="texto1" rows="6" readonly>{{ $secao->texto }}</textarea>
                                        <small class="d-flex justify-content-end align-items-center">
                                            {{ strlen($secao->texto) }} / {{ $secao->limite_caracteres }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            @php
                                // Simulando o texto contendo as tags [img]
                                $texto = $secao->texto;
                                // Extraindo os IDs das imagens do texto usando expressão regular
                                preg_match_all('/\[img(\d+)\]/', $texto, $matches);
                                // IDs das imagens extraídos do texto
                                $idsImagens = array_unique($matches[1]);
                                // Filtrando a coleção de imagens para manter apenas aquelas com os IDs extraídos
                                $imagensFiltradas = $secao->imagens->whereIn('id', $idsImagens);
                            @endphp

                            @if($imagensFiltradas->count())
                            <div class="form-group">
                                <h5>Imagens utilizadas</h5>
                                <div class="row">
                                    @foreach($imagensFiltradas as $imagem)
                                        <div class="col-6">
                                            <div class="card">
                                                <div class="card-content">
                                                    <div class="card-body">
                                                        <small class="badge badge-primary"><strong>[img{{ $imagem->id }}]</strong></small>
                                                        <div style="display: inline-block; position: relative;">
                                                            <img src="{{ asset($imagem->url_imagem) }}" alt="{{ $imagem->legenda }}" class="card-img-top" style="width: 100%;">
                                                        </div>
                                                        <p class="card-text">{{ $imagem->type() }}: {{ $imagem->legenda }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif 
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 d-flex justify-content-end align-items-center">
                            <div class="btn-group pull-right" role="group" aria-label="...">
                                @if($secao->status == 2 && $secao->email_status !== 1)
                                    @if($secao->user_id)
                                        <a href="{{ route('sec_forms.correcao', [$secao->uuid, $secao->usuario->uuid]) }}" class="btn btn-sm btn-warning"><i class="bx bx-error"></i> SOLICITAR CORREÇÃO</a>
                                        <a href="{{ route('sec_forms.status', [$secao->uuid, 5, auth()->user()->uuid]) }}" class="btn btn-sm btn-success atualiza_status"><i class="bx bxs-like"></i> APROVAR</a>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
                <div class="card-footer">
                    <div class="row">
                        <div class="col-12 d-flex justify-content-end">
                            <a class="btn btn-link  pull-left" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card">
        <div class="card-content">
            <div class="card-body">
                <h3 class="text-center alert alert-info">Não há seções!</h3>
            </div>
        </div>
    </div>
    @endif
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endsection
@section('scripts')
<script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
<script nonce="{{ csp_nonce() }}">
    $(document).ready(function () {
        $(".select2").select2({
            allowClear: true,
        });
    });
    document.getElementById('generate-report-btn').addEventListener('click', function() {
        Swal.fire({
            title: 'Deseja realmente gerar o relatório?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sim, gerar!',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('relatorio-form').submit();
            }
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
                    if(response.status == 200){                        
                        Swal.fire(
                            'Sucesso!',
                            response.message,
                            'success'
                        ).then(() => {
                            location.reload();
                        });
                    }else{
                        Swal.fire(
                            'Ops!',
                            'Erro: ' + response.message,
                            'error'
                        );
                    }
                },
                error: function(xhr) {
                    console.log(xhr); // Exibe o objeto de erro no console
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        Swal.fire(
                            'Ops!',
                            'Erro: ' + xhr.responseJSON.message,
                            'error'
                        );
                    } else {
                        Swal.fire(
                            'Erro!',
                            'Erro desconhecido',
                            'error'
                        );
                    }
                }
            });
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
                Swal.fire(
                    'Aviso!',
                    'Não há títulos ou subtítulos disponíveis. Por favor, adicione um título primeiro.',
                    'warning'
                );
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

    $(document).ready(function() {
        // Configura o AJAX com o token CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Lida com o evento de clique no botão 'atualiza_status'
        $('.atualiza_status').on('click', function(event) {
            event.preventDefault(); // Impede a navegação padrão

            var $button = $(this); // Referência ao botão clicado
            var actionUrl = $button.attr('href'); // Obtém a URL do link

            // Desabilita temporariamente todos os botões no grupo
            $('.btn-group .btn').prop('disabled', true);

            // Mostra o alerta de carregamento ao iniciar o processo
            Swal.fire({
                title: "Enviando e-mail e finalizando seção formulário",
                html: "Aguarde...",
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            // Envia a requisição AJAX
            $.ajax({
                url: actionUrl,
                method: 'GET', // Utilize PUT para a aprovação, ajuste conforme sua rota
                success: function(response) {
                    // Fechar o alerta de carregamento
                    Swal.close();

                    // Trata a resposta de sucesso aqui
                    Swal.fire(
                        'Sucesso!',
                        response.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    // Fechar o alerta de carregamento em caso de erro
                    Swal.close();

                    // Trata os erros aqui
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro ao atualizar o status.',
                        'error'
                    );
                    console.log(xhr.responseText);
                },
                complete: function() {
                    // Reativa os botões após o término da requisição (com ou sem erro)
                    $('.btn-group .btn').prop('disabled', false);
                }
            });
        });
    });

</script>
<script>
    function iniciarFormulario(route) {
        // Mostrar o alerta de carregamento ao iniciar o processo
        Swal.fire({
            title: "Enviando e-mails e iniciando formulário",
            html: "Aguarde...",
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Realizar a requisição AJAX
        fetch(route)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Erro ao iniciar o formulário');
                }
                return response.json();
            })
            .then(response => {
                // Fechar o alerta de carregamento
                Swal.close();

                // Exibir o SweetAlert com base no status recebido
                if (response.status === 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sucesso!',
                        text: response.message
                    }).then(() => {
                        // Atualizar a página após o sucesso
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Erro!',
                        text: response.message,
                        footer: '<a href>Entre em contato conosco</a>'
                    });
                }
            })
            .catch(error => {
                // Fechar o alerta de carregamento em caso de erro
                Swal.close();

                // Exemplo de mensagem de erro genérica
                Swal.fire({
                    icon: 'error',
                    title: 'Erro ao iniciar o formulário',
                    text: 'Por favor, tente novamente mais tarde.',
                    footer: '<a href>Entre em contato conosco</a>'
                });
            });
    }
</script>
<script>
    $(document).ready(function() {
        // Configura o AJAX com o token CSRF
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        // Lida com o evento de clique no botão 'atualiza_status'
        $('.desaprova_status').on('click', function(event) {
            event.preventDefault(); // Impede a navegação padrão

            var $button = $(this); // Referência ao botão clicado
            var actionUrl = $button.attr('href'); // Obtém a URL do link

            // Desabilita temporariamente todos os botões no grupo
            $('.btn-group .btn').prop('disabled', true);
            // Envia a requisição AJAX
            $.ajax({
                url: actionUrl,
                method: 'GET', // Utilize PUT para a aprovação, ajuste conforme sua rota
                success: function(response) {
                    // Fechar o alerta de carregamento
                    Swal.close();

                    // Trata a resposta de sucesso aqui
                    Swal.fire(
                        'Sucesso!',
                        response.message,
                        'success'
                    ).then(() => {
                        location.reload();
                    });
                },
                error: function(xhr) {
                    // Fechar o alerta de carregamento em caso de erro
                    Swal.close();

                    // Trata os erros aqui
                    Swal.fire(
                        'Erro!',
                        'Ocorreu um erro ao atualizar o status.',
                        'error'
                    );
                    console.log(xhr.responseText);
                },
                complete: function() {
                    // Reativa os botões após o término da requisição (com ou sem erro)
                    $('.btn-group .btn').prop('disabled', false);
                }
            });
        });
    });
</script>
@if(session('message'))
    <script>
        Swal.fire({
            position: "center",
            icon: "success",
            title: '{{ session('message') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif
@if(session('error'))
    <script>
        Swal.fire({
            position: "center",
            icon: "error",
            title: '{{ session('error') }}',
            showConfirmButton: false,
            timer: 1500
        });
    </script>
@endif

<script>
    @foreach($formulario->secoes as $secao)
    $(document).ready(function(){
        var status = {{ $secao->status }}; // Define o passo atual com base no status passado do Laravel
        var smartwizardId = "#smartwizard-{{ $secao->id }}";
        // Inicializa o SmartWizard
        $('.smartwizard_'+status).smartWizard({
            selected: status, // Define o passo atual
            theme: 'dots', // Usa o tema "dots"
            transition: {
                animation: 'fade', // Animation effect on navigation, none|fade|slideHorizontal|slideVertical|slideSwing|css(Animation CSS class also need to specify)
                speed: '400', // Animation speed. Not used if animation is 'css'
            },
            toolbar: {
                showNextButton: false, // Esconder o botão Next
                showPreviousButton: false // Esconder o botão Previous
            },
            anchor: {
                enableNavigation: false //Desabilitar navegação anterior
            },
        });
    });
    @endforeach
</script>


@endsection
