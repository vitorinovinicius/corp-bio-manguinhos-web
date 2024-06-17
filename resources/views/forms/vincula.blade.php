@extends('layouts.frest_template')

@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-8 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Vincula</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item active">Vincula</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')

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
                    @foreach($formulario->secoes as $secao)
                        @if(auth()->user()->setores->contains('id', $secao->setor_id))
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
                            </div>
                            <form id="vincula_usuario_{{ $secao->uuid }}" class="form form-vertical" action="{{ route('sec_forms.update', $secao->uuid) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method("PUT")
                                <input type="hidden" name="gerente_id" value="{{auth()->user()->id}}">
                                <div class="card-body">
                                    <div class="row">
                                        @if($secao->status == 0 && $secao->email_status == 1)
                                            <div class="col-12 d-flex justify-content-center">
                                                <p><span class="badge badge-warning"> Aguardando confirmação de e-mail</span></p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">Setor</label>
                                                    <p class="form-control-static">{{ $secao->setor->name ?? '' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="user_id">Responsável*</label>
                                                    <p class="form-control-static">{{ $secao->usuario->name ?? '' }}</p>
                                                </div>
                                            </div>
                                            @else                                        
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="name">Setor</label>
                                                    <p class="form-control-static">{{ $secao->setor->name ?? '' }}</p>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="user_id">Responsável*</label>
                                                    <select class="form-control select2" id="user_id_{{ $secao->uuid }}" name="user_id" data-placeholder="Selecione o responsável em editar essa seção" required>
                                                        <option value="" selected disabled hidden></option>
                                                        @foreach($secao->setor->users as $usuario)
                                                            <option value="{{$usuario->id}}" {{$secao->user_id == $usuario->id? "selected" : ""}}>{{$usuario->name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="name">{{ !$secao->secao_id ? 'Titulo' : 'Sub-titulo' }}</label>
                                                <p class="form-control-static">{{ $secao->descricao }}</p>
                                            </div>
                                        </div>
                                    </div>                        
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="texto1">Texto</label>
                                                <textarea class="form-control" id="texto1_{{ $secao->uuid }}" rows="6" readonly>{{ $secao->texto }}</textarea>
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
                                                                <small><strong>[img{{ $imagem->id }}]</strong></small>
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
                                <div class="card-footer">
                                    <div class="row">
                                        <div class="col-12 d-flex justify-content-end">
                                            @if(!$secao->user_id)
                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('vincula_usuario_{{ $secao->uuid }}').submit();">Vincular responsável</button>
                                            @else
                                            <button type="button" class="btn btn-primary" onclick="document.getElementById('vincula_usuario_{{ $secao->uuid }}').submit();">Alterar responsável</button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <hr>
                            </form>
                        @endif
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
    </div>
@endsection

@section('scripts')
    <script nonce="{{ csp_nonce() }}">
        $(document).ready(function () {
            $(".select2").select2({
                allowClear: true,
            });
        });
        @foreach($formulario->secoes as $secao)
            @if(auth()->user()->setores->contains('id', $secao->setor_id))
                $(document).ready(function(){
                    var status = {{ $secao->status }}; // Define o passo atual com base no status passado do Laravel

                    // Inicializa o SmartWizard
                    $('.smartwizard_'+ status).smartWizard({
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
            @endif
        @endforeach
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
                timer: 3000
            });
        </script>
    @endif
@endsection
