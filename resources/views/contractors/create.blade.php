@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Empresas</li>
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
                    <h3 class="box-title">Criar Empresa</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('contractors.store') }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" placeholder="Nome" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">CNPJ</label>
                                            <input type="text" class="form-control" name="cnpj" value="{{ old('cnpj') }}" placeholder="CNPJ" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço completo*</label>
                                            <input type="text" class="form-control" name="address" value="{{ old('address') }}" placeholder="Endedeço completo" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Telefone 1*</label>
                                            <input type="text" class="form-control" name="phone1" value="{{ old('phone1') }}" placeholder="Telefone 1" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Telefone 2</label>
                                            <input type="text" class="form-control" name="phone2" value="{{ old('phone2') }}" placeholder="Telefone 2" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">E-mail</label>
                                            <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="E-mail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Site</label>
                                            <input type="text" class="form-control" name="site" value="{{ old('site') }}" placeholder="Site" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="client_limit">Limite de cliente</label>
                                            <input type="numeric" class="form-control" name="client_limit" value="{{ old('client_limit') }}" placeholder="Limite de clientes" autocomplete="off">
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox1" name="send_sms" value=1>
                                                <label class="form-check-label" for="inlineCheckbox1">Enviar SMS</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input cs_checkbox" type="checkbox" id="inlineCheckbox2" name="send_mail" value=1>
                                            <label class="form-check-label" for="inlineCheckbox2">Enviar e-mail</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Enviar copia e-mail</label>
                                            <select class="form-control select2" name="send_email_bbc" required data-placeholder="Selecione" required>
                                                <option></option>
                                                <option value="1">Enviar somente para cliente</option>
                                                <option value="2">Enviar somente para o operador</option>
                                                <option value="3">Enviar para ambos (cliente e operador)</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Icone</label>
                                            <input type="file" class="form-control" name="iconeFile">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Logo do cabeçalho</label>
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
                                            <input type="text" class="form-control" name="mail_driver" value="{{ old('mail_driver') }}" placeholder="Driver" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Host</label>
                                            <input type="text" class="form-control" name="mail_host" value="{{ old('mail_host') }}" placeholder="Host" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Porta</label>
                                            <input type="text" class="form-control" name="mail_port" value="{{ old('mail_port') }}" placeholder="Porta" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço de envio</label>
                                            <input type="text" class="form-control" name="mail_from_address" value="{{ old('mail_from_address') }}" placeholder="Endereço de envio" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Endereço de envio - Nome</label>
                                            <input type="text" class="form-control" name="mail_from_name" value="{{ old('mail_from_name') }}" placeholder="Endereço de envio - Nome" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Criptografia</label>
                                            <input type="text" class="form-control" name="mail_encryption" value="{{ old('mail_encryption') }}" placeholder="Criptografia" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Usuário/E-mail</label>
                                            <input type="text" class="form-control" name="mail_username" value="{{ old('mail_username') }}" placeholder="Usuário/E-mail" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Senha</label>
                                            <input type="text" class="form-control" name="mail_password" value="{{ old('Senha') }}" placeholder="Senha" autocomplete="off">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
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
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                placeholder: "Selecione um supervisor",
                allowClear: true
            });
        });
    </script>
@endsection
