@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection
@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Clientes / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Clientes</li>
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
                    <h3 class="box-title">Dados do cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('occurrence_clients.store') }}" method="POST"
                              >
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name">Nome completo do cliente</label>
                                            <input type="text" class="form-control" id="client_name" name="name"
                                                   value="{{ old('name') }}" autocomplete="off"
                                                   placeholder="Nome completo do cliente" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="client_number">Número externo do cliente</label>
                                            <input type="text" class="form-control" id="client_number"
                                                   name="client_number" value="{{ old('client_number') }}"
                                                   autocomplete="off" placeholder="Nº cliente">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="email">E-mail</label>
                                            <input type="email" class="form-control" id="email" name="email"
                                                   value="{{ old('email') }}" autocomplete="off" placeholder="email">
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="cpf_cnpj">CPF ou CNPJ</label>
                                            <input type="text" class="form-control" id="cpf" name="cpf_cnpj"
                                                   value="{{ old('cpf_cnpj') }}" autocomplete="off"
                                                   placeholder="CPF ou CNPJ">
                                        </div>
                                    </div>
                                </div>
                                <div class="divPhonePrincipal">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="phones">Telefone</label>
                                                <input type="text" class="form-control" id="phones" name="phones[]"
                                                    autocomplete="off" placeholder="Telefone">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group">
                                                <label for="Obs">Obs</label>
                                                <input type="text" class="form-control" id="obs" name="obs[]"
                                                       autocomplete="off" placeholder="Observação">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <a href="javascript:void(0);" class="btn btn-info" id="addPhone"><i
                                                        class="bx bx-plus"></i> Adicionar telefone</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="cep">CEP</label>
                                            <div>
                                                <input type="text" class="form-control"
                                                       style="width: calc(100% - 95px);display: inline-block; margin-right: 6px;"
                                                       id="cep" name="cep" value="{{ old('cep') }}" autocomplete="off"
                                                       placeholder="CEP" required>
                                                <a href="javascript:return void(0);" id="busca_cep"
                                                   class="btn-sm btn-success right">Buscar</a>
                                                <i class="cs-loading" style="display:none;"></i>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="address">Endereço</label>
                                            <input type="text" class="form-control" id="address" name="address"
                                                   value="{{ old('address') }}" autocomplete="off"
                                                   placeholder="Endereço" required>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="number">Nº</label>
                                            <input type="text" class="form-control" id="number" name="number"
                                                   value="{{ old('number') }}" autocomplete="off" placeholder="Nº"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="district">Bairro</label>
                                            <input type="text" class="form-control" id="district" name="district"
                                                   value="{{ old('district') }}" autocomplete="off" placeholder="Bairro"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="city">Cidade</label>
                                            <input type="text" class="form-control" id="city" name="city"
                                                   value="{{ old('city') }}" autocomplete="off" placeholder="Cidade"
                                                   required>
                                        </div>
                                    </div>
                                    <div class="col-2">
                                        <div class="form-group">
                                            <label for="uf">Estado*</label>
                                            <select class="form-control select2" id="uf" name="uf" required
                                                    data-placeholder="Estado">
                                                <option></option>
                                                @forelse(uf_list() as $key=>$value)
                                                    <option value="{{$key}}" {{(old('uf')==$key?"selected":"")}}>{{$value}}
                                                        ({{$key}})
                                                    </option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class='row'>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="zone">Zona</label>
                                            <select class="form-control select2" name="zone_id" data-placeholder="Selecione uma zona">
                                                <option></option>
                                                @forelse(\App\Models\Zone::all() as $zone)
                                                    <option value="{{$zone->id}}">{{$zone->zone}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="complement">Complemento</label>
                                            <input type="text" class="form-control" id="complement" name="complement"
                                                   value="{{ old('complement') }}" autocomplete="off"
                                                   placeholder="Complemento">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="reference">Referência</label>
                                            <input type="text" class="form-control" id="reference" name="reference"
                                                   value="{{ old('reference') }}" autocomplete="off"
                                                   placeholder="Referência">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Criar</button>
                                        <a class="btn btn-link pull-right"
                                           href="{{ route('occurrence_clients.index') }}"><i
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
                allowClear: true,
            });
            $(document).on("click", "#addPhone", function (e) {
                e.preventDefault();
                $('<div class="row">' +
                    '<div class="col-4">' +
                        '<div class="form-group">' +
                            '<label for="phone">Telefone</label>' +
                            '<input type="text" class="form-control" name="phones[]" autocomplete="off" placeholder="Telefone">' +
                        '</div>' +
                    '</div>' +
                    '<div class="col-4">' +
                        '<div class="form-group">' +
                            '<label for="Obs">Obs</label>' +
                            '<input type="text" class="form-control" name="obs[]" autocomplete="off" placeholder="Observação">' +
                            '<i class="bx bx-trash remove-row" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                        '</div>' +
                    '</div>' +
                    '</div>').appendTo(".divPhonePrincipal");
                return false;
            });
            $(document).on("click", ".remove-row", function () {
                $(this).parent().parent().parent().remove();
            });
        });

    </script>
    {{--BUSCA CEP--}}
    @include('helpers.busca_cep_helper')
@endsection
