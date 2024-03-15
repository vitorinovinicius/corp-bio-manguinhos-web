@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Empresas / Editar</h5>
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
    @include('messages')
    @include('error')

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('contractors.admin.update') }}" method="POST" enctype="multipart/form-data">
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
                                        <hr>
                                        <div class="form-group">
                                            <label for="name">Ícone
                                                <small>(Tamanho máximo de 48px X 48px) - @if($contractor->icon) - Já existe para substituir selecione outro @endif</small></label>
                                            @if($contractor->icon)
                                                <div class="col-md-4">
                                                    <br>
                                                    <img style="display: block; max-width: 100%; max-height:48px;" src="{{$contractor->icon}}" alt="" class="img-responsive"><br>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="iconeFile">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <hr>
                                        <div class="form-group">
                                            <label for="name">Logo do cabeçalho @if($contractor->logo_cabecalho) - Já existe para substituir selecione outro @endif</label>
                                            @if($contractor->logo_cabecalho)
                                                <div class="col-md-4">
                                                    <br>
                                                    <img style="display: block; max-width: 100%; height:100px;" src="{{$contractor->logo_cabecalho}}" class="img-responsive cs_logo_cabecalho"><br>
                                                </div>
                                            @endif
                                            <input type="file" class="form-control" name="logo_cabecalho">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 mt-1 mb-2">
                                        <hr>
                                        <h4>Configurações de e-mail</h4>
                                    </div>
                                </div>

                                <div class="row">

                                    <div class="col-12">
                                        <div class="form-group">

                                            <ul class="list-unstyled mb-0">
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="radio">
                                                            <input type="radio" name="send_mail" id="radio1" value="1" @if($contractor->send_mail == 1) checked @endif>
                                                            <label for="radio1">Sim</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                                <li class="d-inline-block mr-2 mb-1">
                                                    <fieldset>
                                                        <div class="radio">
                                                            <input type="radio" name="send_mail" id="radio2" value="0" @if($contractor->send_mail == 0) checked @endif>
                                                            <label for="radio2">Não</label>
                                                        </div>
                                                    </fieldset>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

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
                                            <label for="name">E-mail de envio</label>
                                            <input type="text" class="form-control" name="mail_from_address" value="{{ (old('mail_from_address'))? old('mail_from_address') : $contractor->mail_from_address}}" placeholder="E-mail de envio" autocomplete="off">
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
                                            <input type="password" class="form-control" name="mail_password" placeholder="Senha" autocomplete="off">
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Repita a senha</label>
                                            <input type="password" class="form-control" name="re_mail_password" placeholder="Repita a senha" autocomplete="off">
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Salvar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('contractors.admin.show') }}"><i
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
