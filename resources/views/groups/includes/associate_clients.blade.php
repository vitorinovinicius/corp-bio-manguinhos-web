@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Grupo - {{ $group->name }} - Associar Usuário</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Grupo</li>
                        <li class="breadcrumb-item active">Associar Usuá rio</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')

    {{--FILTROS INICIO--}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Filtro </h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label>Cliente</label>
                                            <select class="form-control occurrence_client_id" id="occurrence_client_id" name="occurrence_client_id">
                                                <option></option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="dataClient" style="margin-top:16px">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="client_id">ID</label>
                                                <input type="text" class="form-control" id="client_id" name="client_id" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="client_name">Nome</label>
                                                <input type="text" class="form-control" id="client_name" name="client_name" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="text" class="form-control" id="email" name="email" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="phone">Telefone</label>
                                                <input type="text" class="form-control" id="phone" name="phone" readonly>
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cpf_cnpj">CPF/CNPJ</label>
                                                <input type="text" class="form-control" id="cpf_cnpj" name="cpf_cnpj" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="address">Endereço</label>
                                                <input type="text" class="form-control" id="address" name="address" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="number">Número</label>
                                                <input type="text" class="form-control" id="number" name="number" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="client_number">Número do Cliente</label>
                                                <input type="text" class="form-control" id="client_number" name="client_number" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="cep">CEP</label>
                                                <input type="text" class="form-control" id="cep" name="cep" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="district">Bairro</label>
                                                <input type="text" class="form-control" id="district" name="district" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="city">Cidade</label>
                                                <input type="text" class="form-control" id="city" name="city" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="uf">UF</label>
                                                <input type="text" class="form-control" id="uf" name="uf" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="complement">Complemento</label>
                                                <input type="text" class="form-control" id="complement" name="complement" readonly>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="reference">Referencia</label>
                                                <input type="text" class="form-control" id="reference" name="reference" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="zone">Zona</label>
                                                <input type="text" class="form-control" id="zone" name="zone" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12 d-flex justify-content-end">
                                        <a href="javascript:void(0);" class="btn btn-info" id="btn-external-filter"><i
                                            class="bx bx-plus"></i> OK </a>
                                        
                                        <a href="{{ route('users.associate.skill', $group->uuid) }}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                       
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Clientes </h4>
                    <a class="heading-elements-toggle">
                        <i class="bx bx-dots-vertical font-medium-3"></i>
                    </a>
                    <div class="heading-elements">
                        <ul class="list-inline mb-0">
                            <li>
                                <a data-action="collapse">
                                    <i class="bx bx-chevron-down"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body">
                        <form class="form form-vertical" action="{{ route('users.associate.occurrence_clients.store', $group->uuid) }}" method="POST" enctype="multipart/form-data">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-body">
                                <div id="list_client">
                                    <div class="col-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary">Associar</button>
                                        </div>
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

    {{--FILTROS FIM--}}

    {{-- <meta name="_token" content="{!! csrf_token() !!}"/> --}}

@section('scripts')
    <!-- Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    {{-- <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    {{-- <script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script> --}}
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $(".select2").select2({
                allowClear: true,
            });
            
            $selectElement = $("#occurrence_client_id").select2({
                allowClear: true,
                ajax: {
                    delay: 1000,
                    url: "{{ route('occurrence_client.get_ajax_select2') }}",
                    data: function (params) {
                        var query = {
                            search: params.term,
                            type: 'public'
                        }

                        // Query parameters will be ?search=[term]&type=public
                        return query;
                    },
                    processResults: function (data) {
                        // Transforms the top-level key of the response object from 'items' to 'results'
                        return {
                            results: data.items
                        };
                    },

                },
                placeholder: 'Selecione o cliente',
                minimumInputLength: 3,
                templateResult: formatRepo,
                templateSelection: formatRepoSelection
            });

            function formatRepo(repo) {

                if (repo.loading) {
                    return repo.text;
                }

                let clientNumber = (repo.client_number != null) ? " - (" + repo.client_number + ")" : "";

                return $(
                    "<option class='select2-result-repository__title' value=" + repo.id + ">" + repo.id + " - " + repo.name + clientNumber + "</option>"
                );
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }

            var $occurrence_client_id = $(".occurrence_client_id");

            $occurrence_client_id.on("select2:select", function (e) {
                var oc_id = $(this).val();
                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/occurrence_type/client_ajax/' + oc_id,
                    success: function (data) {

                        console.log(data)
                    
                        if (data == "") {
                            alert("Dados do usuário não encontrados");
                        } else {
                            $("#client_id").val(data.id).prop('readonly', true);
                            $("#client_name").val(data.name).prop('readonly', true);
                            $("#email").val(data.email).prop('readonly', true);
                            $("#phone").val(data.phone).prop('readonly', true);
                            $("#cpf_cnpj").val(data.cpf_cnpj).prop('readonly', true);
                            $("#address").val(data.address).prop('readonly', true);
                            $("#number").val(data.number).prop('readonly', true);
                            $("#client_number").val(data.client_number).prop('readonly', true);
                            $("#cep").val(data.cep).prop('readonly', true);
                            $("#district").val(data.district).prop('readonly', true);
                            $("#city").val(data.city).prop('readonly', true);
                            $("#uf").val(data.uf).prop('readonly', true);
                            $("#complement").val(data.complement).prop('readonly', true);
                            $("#reference").val(data.reference).prop('readonly', true);
                            $("#zone").val(data.zone).prop('readonly', true);
                        }
                    }
                });

            });
            $occurrence_client_id.on("select2:unselect", function (e) {
                $("#client_id").val("").prop('readonly', false);
                $("#client_name").val("").prop('readonly', false);
                $(".phones").val("").prop('readonly', false);
                $("#email").val("").prop('readonly', false);
                $("#cpf_cnpj").val("").prop('readonly', false);
                $("#address").val("").prop('readonly', false);
                $("#number").val("").prop('readonly', false);
                $("#client_number").val("").prop('readonly', false);
                $("#cep").val("").prop('readonly', false);
                $("#district").val("").prop('readonly', false);
                $("#city").val("").prop('readonly', false);
                $("#uf").val("").prop('readonly', false);
                $("#complement").val("").prop('readonly', false);
                $("#reference").val("").prop('readonly', false);
                $("#zone").val("").prop('readonly', false);

                //remove telefones
                $(".divPhoneNew").remove();
            });

            //FIM - AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO

            @if (count($errors) > 0 && !empty(old('occurrence_client_id')))
            $("#client_id").prop('readonly', true);
            $("#client_name").prop('readonly', true);
            $("#phone").prop('readonly', true);
            $("#email").prop('readonly', true);
            $("#cpf_cnpj").prop('readonly', true);
            $("#address").prop('readonly', true);
            $("#number").prop('readonly', true);
            $("#client_number").prop('readonly', true);
            $("#cep").prop('readonly', true);
            $("#district").prop('readonly', true);
            $("#city").prop('readonly', true);
            $("#uf").prop('readonly', true);
            $("#complement").prop('readonly', true);
            $("#reference").prop('readonly', true);
            $("#zone").prop('readonly', true);
            @endif

            $(document).on("click", "#btn-external-filter", function (e) {
                console.log()
                e.preventDefault();
                $('<div class="row">' +
                        '<div class="col-2">' +
                            '<div class="form-group">' +
                                '<label for="occurrence_client_id">ID</label>' +
                                '<input type="text" class="form-control" name="occurrence_client_id[]" autocomplete="off" value="'+$("#client_id").val() +'">' +
                            '</div>' +
                        '</div>' +
                        '<div class="col-8">' +
                            '<div class="form-group">' +
                                '<label for="name">Nome</label>' +
                                '<input type="text" class="form-control" name="occurrence_client_name[]" value="'+$("#client_name").val() +'">' +
                                '<i class="bx bx-trash remove-row" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                            '</div>' +
                        '</div>' +                        
                    '</div>').appendTo("#list_client");
                return false;
            });


        });
    </script>
@endsection