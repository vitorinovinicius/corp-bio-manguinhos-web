@extends('layouts.frest_template')

@section('css')
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-8 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Preenchimento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item active">Preenchimento</li>
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
                    <h3 class="box-title">Formulário</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label>Nome do formulário</label>
                                        <p class="form-control-static">{{ $formulario->descricao }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Seções do formulário</h3>
                </div>
                <div class="card-content">
                    @foreach($formulario->secoes->where('user_id', auth()->user()->id) as $secao)
                        <div class="card-header">
                            <h4>Seção #{{$secao->id}}</h4>
                            <div class="smartwizard-container">
                                
                                <div id="smartwizard-{{ $secao->id }}" class="smartwizard_{{ $secao->status }}">
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

                            @if($secao->status !== 2 && $secao->status !== 4)
                                @if($secao->status == 1 && $secao->email_status !== 1||$secao->status == 3 && $secao->email_status !== 1)
                                    <form id="status-form-{{ $secao->id }}" action="{{ route('sec_forms.status', [$secao->uuid, 1]) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('PUT')
                                        <div class="d-flex justify-content-end" role="group" aria-label="...">
                                            <button type="submit" class="btn btn-icon btn-success"><i class="bx bxs-like"></i> Finalizar</button>
                                        </div>
                                    </form>
                                @endif
                            @endif
                        </div>
                        
                        <form id="atualizaTexto-{{ $secao->id }}" class="form form-vertical" action="{{ route('sec_forms.update', $secao->uuid) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method("PUT")
                            @if(auth()->user()->id == $secao->user_id)
                                @php
                                    $validacao_status = array(2, 4);
                                @endphp
                                @if(!in_array($secao->statu, $validacao_status) && $secao->status == 3 && $secao->email_status == 2 || $secao->status == 1 && $secao->email_status !== 1)
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">Setor</label>
                                                    <p class="form-control-static">{{ $secao->setor->name ?? '' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label for="name">Responsável</label>
                                                    <p class="form-control-static">{{ $secao->usuario->name ?? 'Não designado' }}</p>
                                                </div>
                                            </div>
                                            @if($secao->status == 3)
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        @php
                                                            $email_correcao = $secao->usuario->emailsRecebidos()->where('secao_formulario_id', $secao->id)->pluck('corpo')->last();
                                                            $email_correcao = str_replace('<br>', "\n", $email_correcao);
                                                        @endphp
                                                        <label for="name" class="d-flex justify-content-center">E-mail</label>
                                                        <span class="badge {{ $secao->badge_status() }}" data-toggle="tooltip" data-placement="left" title="{{$secao->status == 3?$email_correcao:'Notificações'}}">O que corrigir?</span>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">{{ $secao->secao_id ? 'Sub-titulo' : 'Titulo' }}</label>
                                                    <p class="form-control-static">{{ $secao->descricao }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="texto_salvo">Texto</label>
                                                    <textarea class="form-control texto_salvo_{{ $secao->id }}" rows="6" id="texto_{{ $secao->id }}" name="texto">{{ $secao->texto }}</textarea>
                                                    <small><span class="charCount_{{ $secao->id }}"></span></small>
                                                </div>
                                            </div>
                                        </div>
                                        @if($secao->imagens->count())
                                            <div class="form-group">
                                                <h5>Imagens disponíveis</h5>
                                                <div class="row">
                                                    @foreach($secao->imagens as $imagem)
                                                        <div class="col-6">
                                                            <div class="card">
                                                                <div class="card-content">
                                                                    <div class="card-body">
                                                                        <small class="badge badge-primary"><strong>[img{{ $imagem->id }}]</strong></small>
                                                                        <div style="display: inline-block; position: relative;">
                                                                            <img src="{{ asset($imagem->url_imagem) }}" alt="{{ $imagem->legenda }}" class="card-img-top" style="width: 100%; cursor: pointer;" onclick="inserirImagemTag('{{ $imagem->id }}','{{ $secao->id }}')">
                                                                            <a href="{{ route('imagens.edit', $imagem->uuid) }}" class="btn btn-warning btn-icon btn-sm" data-toggle="tooltip" data-placement="bottom" title="Editar imagem" data-uuid="{{ $imagem->uuid }}" style="position: absolute; top: 40px; right: 5px;"><i class="bx bx-pencil"></i></a>
                                                                            <button class="btn btn-danger btn-icon btn-sm delete-button" data-toggle="tooltip" data-placement="top" title="Excluir imagem" data-uuid="{{ $imagem->uuid }}" style="position: absolute; top: 5px; right: 5px;">
                                                                                <i class="bx bx-x"></i>
                                                                            </button>
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
                                        
                                        <div class="col-12">
                                            <div class="d-flex justify-content-center">
                                                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#storeImagemModal" onclick="inserirImagem('{{ $secao->id }}')">
                                                    <i class="bx bx-plus"></i> 
                                                    Adicionar imagem
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="card-body">
                                        <div class="row">
                                            @if($secao->status == 2 && $secao->email_status == 1) 
                                            <div class="col-12 d-flex justify-content-center">
                                                <p><span class="badge badge-warning"> Acesse a sua caixa de e-mail e confirme o recebimento.</span></p>
                                            </div>
                                            @elseif($secao->status == 4 && $secao->email_status == 2)
                                            <div class="col-12 d-flex justify-content-center">
                                                <p><span class="badge badge-success"> Seção finalizada!</span></p>
                                            </div>
                                            @else
                                            <div class="col-12 d-flex justify-content-center">
                                                <p><span class="badge badge-warning"> Aguardando confirmação de e-mail</span></p>
                                            </div>
                                            @endif
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">Setor</label>
                                                    <p class="form-control-static">{{ $secao->setor->name ?? '' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">Responsável</label>
                                                    <p class="form-control-static">{{ $secao->usuario->name ?? 'Não designado' }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="name">{{ $secao->secao_id ? 'Sub-titulo' : 'Titulo' }}</label>
                                                    <p class="form-control-static">{{ $secao->descricao }}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="texto_salvo">Texto</label>
                                                    <textarea class="form-control texto_salvo_{{ $secao->id }}" rows="6" id="texto_{{ $secao->id }}" name="texto" readonly>{{ $secao->texto }}</textarea>
                                                    <small><span class="charCount_{{ $secao->id }}"></span></small>
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
                                @endif
                                <hr>
                            @else
                                <h3 class="text-center alert alert-info">Não há seção vinculada ao seu usuário.</h3>
                            @endif
                        </form>
                    @endforeach
                    
                    @include('forms.include.add_imagem_modal')
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
    </div>
@endsection

@section('scripts')

<script>
    @foreach($formulario->secoes->where('user_id', auth()->user()->id) as $secao)
        $(document).ready(function () {
            var maxLength = {{ $secao->limite_caracteres }};
            var isDirty = false; // Flag para verificar se houve alterações
            var secaoId = {{ $secao->id }};

            // Função para remover tags de imagem do texto
            function removeTags(text) {
                return text.replace(/\[img\d+\]/g, '');
            }

            // Função para atualizar contador de caracteres
            function updateCharCount() {
                var texto = $('.texto_salvo_' + secaoId).val();
                var textoSemTags = removeTags(texto);

                var charCount = textoSemTags.length;
                $('.charCount_' + secaoId).text(charCount + '/' + maxLength);

                if (charCount >= maxLength) {
                    $('.charCount_' + secaoId).addClass('text-danger'); // Exemplo de estilo para indicar limite
                } else {
                    $('.charCount_' + secaoId).removeClass('text-danger');
                }
            }

            // Contador inicial ao carregar a página
            updateCharCount();

            // Função para inserir a tag da imagem no texto
            window.inserirImagemTag = function(imagemId, secaoId) {
                var textarea = $('#texto_' + secaoId);
                var texto = textarea.val();
                var tag = '[img' + imagemId + ']';
                textarea.val(texto + tag);
                isDirty = true; // Marca como alterado
                updateCharCount(secaoId); // Atualiza a contagem de caracteres
            }

            // Função para deletar tag inteira
            function removePartialTags(text) {
                return text.replace(/\[img\d*\]?/, '');
            }

            // Evento de digitação no textarea
            $('.texto_salvo_' + secaoId).on('input', function () {
                var texto = $(this).val();
                var textoSemTags = removeTags(texto);

                var charCount = textoSemTags.length;

                // Verifica se uma parte de uma tag foi deletada e remove a tag inteira
                if (texto.match(/\[img\d*$/)) {
                    texto = removePartialTags(texto);
                    $(this).val(texto);
                }

                if (charCount > maxLength) {
                    var excessLength = charCount - maxLength;
                    var cleanText = textoSemTags.substring(0, maxLength);
                    
                    // Reconstruir o texto original com as tags, mas cortando o excesso de texto real
                    var newText = '';
                    var textIndex = 0;
                    var cleanIndex = 0;

                    // Loop through the original text and reconstruct it with tags
                    while (cleanIndex < cleanText.length) {
                        if (texto[textIndex] === '[' && texto.substring(textIndex).match(/^\[img\d+\]/)) {
                            var tagMatch = texto.substring(textIndex).match(/^\[img\d+\]/)[0];
                            newText += tagMatch;
                            textIndex += tagMatch.length;
                        } else {
                            newText += texto[textIndex];
                            cleanIndex++;
                            textIndex++;
                        }
                    }

                    $(this).val(newText);
                    updateCharCount();
                } else {
                    updateCharCount();
                    isDirty = true; // Marca como alterado quando o usuário digitar algo
                }
            });

            // Salvamento automático apenas se houver alterações
            setInterval(function() {
                if (isDirty) {
                    saveTexto();
                    isDirty = false; // Reseta a flag depois de salvar
                }
            }, 1000);

            // Função para salvar o texto
            function saveTexto() {
                var texto = $('.texto_salvo_' + secaoId).val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('sec_forms.atualiza_texto', $secao->uuid) }}',
                    data: {
                        _method: 'PUT',
                        _token: '{{ csrf_token() }}',
                        secao_id: '{{ $secao->id }}',
                        texto: texto
                    },
                    success: function(response) {
                        console.log('Texto salvo automaticamente.');
                    },
                    error: function(xhr, status, error) {
                        console.error('Erro ao salvar texto automaticamente:', error);
                    }
                });
            }
        });

        $(document).ready(function() {
            $('#status-form-{{ $secao->id }}').off('submit').on('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                Swal.fire({
                    title: 'Deseja realmente finalizar a seção do formulário?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sim',
                    cancelButtonText: 'Não',
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Obtém a URL de ação do formulário
                        var actionUrl = $(this).attr('action');
                        
                        // Serializa os dados do formulário
                        var formData = $(this).serialize();

                        // Envia a requisição AJAX
                        $.ajax({
                            url: actionUrl,
                            method: 'GET',
                            data: formData,
                            success: function(response) {
                                Swal.fire(
                                    'Atualizado!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Erro!',
                                    'Ocorreu um erro ao atualizar seção.',
                                    'error'
                                );
                                console.log(xhr.responseText);
                            }
                        });
                    }
                });
            });
        });

        function inserirImagemTag(imageId, secaoId) {
            const textarea = document.getElementById('texto_'+ secaoId);
            const cursorPos = textarea.selectionStart;
            const textBeforeCursor = textarea.value.substring(0, cursorPos);
            const textAfterCursor = textarea.value.substring(cursorPos);

            // Adiciona a tag de imagem no ponto do cursor
            textarea.value = textBeforeCursor + '[img' + imageId + ']' + textAfterCursor;
        }
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
    function inserirImagem(secaoId) {
        $('#submitImagem').click(function(e) {
            e.preventDefault();

            var csrfToken = $('meta[name="csrf-token"]').attr('content');

            $('input[name="secao_formulario_id"]').val(secaoId);

            var formData = new FormData($('#storeImagem')[0]);

            $.ajax({
                url: "{{ route('imagens.ajax') }}",
                type: "POST",
                dataType: "json",
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    $('#storeImagem')[0].reset();
                    $('#storeImagemModal').modal('hide');
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
    }
    $(document).ready(function() {
        $('.delete-button').on('click', function(event) {
            event.preventDefault();

            var imagemId = $(this).data('uuid');
            var url = "{{ route('imagens.destroy', ':imagemId') }}";
            url = url.replace(':imagemId', imagemId);

            Swal.fire({
                title: 'Tem certeza?',
                text: 'Caso continue, a imagem será deletada!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sim, quero deletar!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            console.log(response);
                            if (response.status == 200) {
                                $('#imagem-' + imagemId).closest('.col-4').remove(); // Remove o card inteiro da imagem
                                Swal.fire(
                                    'Deletado!',
                                    response.message,
                                    'success'
                                ).then(() => {
                                    location.reload();
                                });
                            } else {
                                Swal.fire(
                                    'Erro!',
                                    'Erro ao deletar imagem.',
                                    'error'
                                );
                            }
                        },
                        error: function(response) {
                            Swal.fire(
                                'Erro!',
                                'Erro ao deletar imagem.',
                                'error'
                            );
                        }
                    });
                }
            });
        });
    });
</script>

@endsection
