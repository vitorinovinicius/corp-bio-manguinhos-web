@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Formulários / Exibir / Solicitar correção</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Formulários</li>
                        <li class="breadcrumb-item ">Exibir</li>
                        <li class="breadcrumb-item active">Solicitar correção</li>
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
                        <div class="col-12 d-flex justify-content-center">
                            <h5 class="box-title">E-mail de correção - Refente à seção #{{$secao->id}}</h5>
                        </div>
                    </div>
                    <hr>
                    <div class="card-content">
                        <form class="form form-vertical" action="{{ route('sec_forms.email_correcao', [$secao->uuid, $secao->usuario->uuid]) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('POST')
                            <div class="card-body">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="texto_salvo">Destinatário</label>
                                                <p class="form-control-static">{{ $usuario->name }}</p>
                                                <input type="hidden" name="destinatario_id" value="{{ $usuario->id }}">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="texto_salvo">Remetente</label>
                                                <p class="form-control-static">{{ auth()->user()->name }}</p>
                                                <input type="hidden" name="remetente_id" value="{{ auth()->user()->id }}">
                                            </div>
                                        </div>
                                    </div>   
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="corpo">Corpo do e-mail</label>
                                                @php
                                                    $email_correcao = auth()->user()->emailsEnviados()->where('secao_formulario_id', $secao->id)->pluck('corpo')->last();
                                                    $email_correcao = str_replace('<br>', "\n", $email_correcao);
                                                @endphp
                                                <textarea class="form-control" rows="6" name="corpo" id="corpo">{{$email_correcao}}</textarea>
                                                <small>*Indique ao <strong class="text-danger">{{$usuario->name}}</strong> o que deve ser corrigido.</small>
                                                <div class="text-right">
                                                    <small id="char_count">0 caracteres</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 d-flex justify-content-center">
                                        <button type="submit" class="btn btn-primary">Enviar</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="modal-footer">
                            <a class="btn btn-link  pull-left" href="{{URL::previous()}}"><i class="bx bx-arrow-back"></i> Voltar</a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const textarea = document.getElementById('corpo');
            const charCount = document.getElementById('char_count');
        
            function updateCharCount() {
                // Contar caracteres sem contar tags <br>
                const text = textarea.value.replace(/<br>/g, '');
                const count = text.length;
                charCount.textContent = count + ' caracteres';
            }
        
            function insertBrAtCursor() {
                const start = textarea.selectionStart;
                const end = textarea.selectionEnd;
                const newValue = textarea.value.substring(0, start) + '\n' + textarea.value.substring(end);
                textarea.value = newValue;
                textarea.selectionStart = textarea.selectionEnd = start + 1;
                updateCharCount();
            }
        
            textarea.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    insertBrAtCursor();
                }
            });
        
            textarea.addEventListener('input', updateCharCount);
        
            textarea.form.addEventListener('submit', function() {
                textarea.value = textarea.value.replace(/\n/g, '<br>');
            });
        });
    </script>
    @parent
    <script>
        // Captura o clique no botão de envio do formulário
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault(); // Impede o envio padrão do formulário

                // Mostra o alerta de carregamento ao iniciar o processo
                Swal.fire({
                    title: "Enviando e-mail.",
                    html: "Aguarde...",
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Submete o formulário
                this.submit();
            });
        });
    </script>
@endsection
