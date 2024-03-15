@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas / Editar #{{$contractor->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Empresas</li>
                        <li class="breadcrumb-item active">Editar</li>
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
                    <h3 class="box-title">Editar Empresa - #{{$contractor->id}}</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('contractors.update', $contractor->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_method" value="PUT">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" id="name" class="form-control" name="name" value="{{$contractor->name}}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CNPJ</label>
                                            <input type="text" class="form-control" id="cnpj" name="cnpj" value="{{ (old('cnpj'))? old('cnpj') : $contractor->cnpj}}" placeholder="CNPJ" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço completo*</label>
                                            <input type="text" class="form-control" id="address" name="address" value="{{ (old('address'))? old('address') : $contractor->address}}" placeholder="Endedeço completo" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Coordenadas</label>
                                            <p class="form-control-static" >{{$contractor->lat}}, {{$contractor->lng}}</p>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Telefone 1*</label>
                                            <input type="text" class="form-control" id="phone1" name="phone1" value="{{ (old('phone1'))? old('phone1') : $contractor->phone1}}" placeholder="Telefone 1" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Telefone 2</label>
                                            <input type="text" class="form-control" id="phone2" name="phone2" value="{{ (old('phone2'))? old('phone2') : $contractor->phone2}}" placeholder="Telefone 2" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ (old('email'))? old('email') : $contractor->email}}" placeholder="E-mail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Site</label>
                                            <input type="text" class="form-control" id="site" name="site" value="{{ (old('site'))? old('site') : $contractor->site}}" placeholder="Site" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="client_limit">Limite de clientes</label>
                                            <input type="numeric" class="form-control" id="client_limit" name="client_limit" value="{{ (old('client_limit'))? old('client_limit') : $contractor->client_limit}}" placeholder="Limite de clientes" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Visibilidade</label>
                                            <select class="form-control select2" name="visibility" id="visibility" required>
                                                <option></option>
                                                <option value="1" {{($contractor->visibility == 1)? "selected" : ""}}>Visível</option>
                                                <option value="0" {{($contractor->visibility != 1)? "selected" : ""}}>Não visível</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox1" name="send_sms" value=1 @if($contractor->send_sms == 1) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox1">Enviar SMS</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox2" name="send_mail" value=1 @if($contractor->send_mail == 1) checked @endif>
                                                <label class="form-check-label" for="inlineCheckbox2">Enviar e-mail</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Enviar copia e-mail</label>
                                            <select class="form-control select2" name="send_email_bbc" required data-placeholder="Selecione" required>
                                                <option></option>
                                                <option value="1" @if($contractor->send_email_bbc == 1) selected @endif>Enviar somente para cliente</option>
                                                <option value="2" @if($contractor->send_email_bbc == 2) selected @endif>Enviar somente para o operador</option>
                                                <option value="3" @if($contractor->send_email_bbc == 3) selected @endif>Enviar somente para ambos (cliente e operador)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Status</label>
                                            <select class="form-control select2" name="status" id="status" required>
                                                <option></option>
                                                <option value="1" {{($contractor->status == 1)? "selected" : ""}}>Habilitada</option>
                                                <option value="0" {{($contractor->status != 1)? "selected" : ""}}>Desabilitada</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Pendência financeira com Central System</label>
                                            <select class="form-control select2" name="financial_pendency" id="financial_pendency" required>
                                                <option></option>
                                                <option value="1" {{($contractor->financial_pendency == 1)? "selected" : ""}}>Sim</option>
                                                <option value="0" {{($contractor->financial_pendency != 1)? "selected" : ""}}>Não</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Icone @if($contractor->icon) - Já existe para substituir selecione outro @endif</label>
                                            @if($contractor->icon)
                                                <div class="col-md-4">
                                                    <img style="display: block; max-width: 100%; height:auto;" src="{{$contractor->icon}}" alt="" class="img-responsive"><br>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="iconeFile">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Logo do cabeçalho @if($contractor->logo_cabecalho) - Já existe para substituir selecione outro @endif</label>
                                            @if($contractor->logo_cabecalho)
                                                <div class="col-md-4">
                                                    <img style="display: block; max-width: 100%; height:auto;" src="{{$contractor->logo_cabecalho}}" class="img-responsive cs_logo_cabecalho"><br>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="logo_cabecalho">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mt-1 mb-2">
                                        <h4>Configurações de e-mail</h4>
                                        <hr>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Driver</label>
                                            <input type="text" class="form-control" name="mail_driver" value="{{ (old('mail_driver'))? old('mail_driver') : $contractor->mail_driver}}" placeholder="Driver" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Host</label>
                                            <input type="text" class="form-control" name="mail_host" value="{{ (old('mail_host'))? old('mail_host') : $contractor->mail_host}}" placeholder="Host" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Porta</label>
                                            <input type="text" class="form-control" name="mail_port" value="{{ (old('mail_port'))? old('mail_port') : $contractor->mail_port}}" placeholder="Porta" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço de envio</label>
                                            <input type="text" class="form-control" name="mail_from_address" value="{{ (old('mail_from_address'))? old('mail_from_address') : $contractor->mail_from_address}}" placeholder="Endereço de envio" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço de envio - Nome</label>
                                            <input type="text" class="form-control" name="mail_from_name" value="{{ (old('mail_from_name'))? old('mail_from_name') : $contractor->mail_from_name}}" placeholder="Endereço de envio - Nome" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Criptografia</label>
                                            <input type="text" class="form-control" name="mail_encryption" value="{{ (old('mail_encryption'))? old('mail_encryption') : $contractor->mail_encryption}}" placeholder="Criptografia" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Usuário/E-mail</label>
                                            <input type="text" class="form-control" name="mail_username" value="{{ (old('mail_username'))? old('mail_username') : $contractor->mail_username}}" placeholder="Usuário/E-mail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Senha</label>
                                            <input type="text" class="form-control" name="mail_password" value="{{ (old('mail_password'))? old('mail_password') : $contractor->mail_password }}" placeholder="Senha" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-info ml-1" href="#" id="test-mail">Testar envio de e-mail</a>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('contractors.index') }}"><i
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
    <script src="/js/sweetalert.js"></script>

    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione um supervisor",
                allowClear: true
            });

            $("#test-mail").click(function(e){
                e.preventDefault();
                Swal.fire({
                    title: 'Informe o e-mail para teste',
                    input: 'text',
                    inputAttributes: {
                        autocapitalize: 'off'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Enviar',
                    showLoaderOnConfirm: true,
                    preConfirm: (mail) => {
                        jQuery.ajax({
                    type: 'GET',
                    data: {to: mail},
                    url: '{{route("mails.test_envio_email",$contractor->uuid)}}',

                    beforeSend: function () {
                        jQuery(".reenviaLaudo").attr('disabled', true);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-refresh fa-spin"></i> Aguarde...');
                    },
                    success: function (data) {
                        console.log(data);
                        jQuery(".reenviaLaudo").attr('disabled', false);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-mail-forward"></i> Envia e-mail');
                        if (data.retorno == 2) {
                            Swal.fire(data.mensagem + data.exception);
                        } else {
                            Swal.fire("E-mail enviado com sucesso!");
                        }
                    },
                    error: function () {
                        jQuery(".reenviaLaudo").attr('disabled', false);
                        jQuery(".reenviaLaudo").html('<i class="bx bx-mail-forward"></i> Envia e-mail');
                        alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then()

            })
        });
    </script>
@endsection
