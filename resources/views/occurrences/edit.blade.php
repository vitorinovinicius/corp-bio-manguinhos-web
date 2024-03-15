@extends('layouts.frest_template')
@section('css')
    /*
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">*/
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">

    <!-- Select2 -->
    {{--    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">--}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>

@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Ordem de Serviço / Editar #{{$occurrence->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Ordem de Serviço</li>
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
            <form class="form form-vertical" action="{{ route('occurrences.update', $occurrence->uuid) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="_method" value="PUT">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                {{--                <input type="hidden" name="occurrence_client_id" value="{{ $occurrence->occurrence_client_id }}">--}}
                <div class="form-body">
                    <div class="row">

                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="box-title">Dados da OS #{{$occurrence->id}}</h3>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-2">
                                                <div class="form-group">
                                                    <label>Número OS</label>
                                                    <input type="text" autocomplete="off" class="form-control" id="numero_os" name="numero_os" value="{{ old('numero_os', $occurrence->numero_os) }}" placeholder="Número OS">
                                                </div>
                                            </div>
                                            @if($occurrence->status == 1)
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Data do agendamento*</label>
                                                        <input type="text" autocomplete="off" class="form-control date-picker" id="schedule_date" name="schedule_date" value="{{ old('schedule_date', $occurrence->schedule_date) }}" placeholder="Data do agendamento" required>
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label>Hora do agendamento</label>
                                                        <input type="time" autocomplete="off" class="form-control" id="schedule_time" name="schedule_time" value="{{ old('schedule_time', $occurrence->schedule_time) }}" placeholder="Hora do agendamento">
                                                    </div>
                                                </div>
                                                <div class="col-2">
                                                    <div class="form-group">
                                                        <label>Turno</label>
                                                        <select class="form-control select2" name="shift" data-placeholder="Turno">

                                                            <option></option>
                                                            <option value="1" {{($occurrence->shift==1?"selected":"")}}>Manhã</option>
                                                            <option value="2" {{($occurrence->shift==2?"selected":"")}}>Tarde</option>
                                                            <option value="3" {{($occurrence->shift==3?"selected":"")}}>Noite</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3">
                                                    <div class="form-group">
                                                        <label>Prioridade*</label>
                                                        <select class="form-control select2" name="priority" required data-placeholder="Prioridade">
                                                            <option></option>
                                                            @forelse(priority_list_array() as $key=>$value)
                                                                <option value="{{$key}}" {{($occurrence->priority==$key?"selected":"")}}>{{$value}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                        </div>

                                        <div class="row">
                                            @if($occurrence->status == 1)
                                                @is(['superuser'])
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Empresa/ Empreiteira*</label>
                                                        <select class="form-control select2" name="contractor_id" data-placeholder="Selecione a empresa/empreiteira" required>
                                                            <option></option>
                                                            @forelse($contractors as $contractor)
                                                                <option value="{{$contractor->id}}" {{(old('contractor_id') || ($occurrence->contractor_id)==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                                @endis

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Tipo da Ocorrência*</label>
                                                        <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione o tipo da Ocorrência">
                                                            <option></option>
                                                            @forelse($occurrence_types as $ot)
                                                                <option value="{{$ot->id}}" {{(old('occurrence_type_id')|| ($occurrence->occurrence_type_id)==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Atribuir para:
                                                            <span class="text-danger text-sm"> Não obrigatório </span></label>
                                                        <select class="form-control select2" name="operator_id" data-placeholder="Escolha um Operador">
                                                            <option></option>
                                                            @forelse($operators as $operator)
                                                                <option value="{{$operator->id}}" {{($operator->id == $occurrence->operator_id ? "selected" : "")}}>{{$operator->name}}</option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Observação</label>
                                                    <textarea rows="7" class="form-control" id="obs_empreiteira" name="obs_empreiteira" placeholder="Observação da Ocorrência">{{ (old('obs_empreiteira'))? old('obs_empreiteira') : $occurrence->obs_empreiteira}}</textarea>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label>Anexo</label>
                                                    <input type="file" class="form-control" name="anexos[]" id="anexo" multiple>
                                                </div>
                                            </div>
                                            @if($occurrence->status == 1)

                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label>Selecione o cliente</label>
                                                        <select class="form-control occurrence_client_id" id="occurrence_client_id" name="occurrence_client_id">
                                                            <option></option>
                                                            @if($occurrence->occurrence_client)
                                                                <option value="{{ $occurrence->occurrence_client_id }}" selected>{{ optional($occurrence->occurrence_client)->client_number ? optional($occurrence->occurrence_client)->client_number . " | " : "" }} {{ optional($occurrence->occurrence_client)->name }} | CPF/CNPJ: {{ optional($occurrence->occurrence_client)->cpf_cnpj }} | E-mail: {{ optional($occurrence->occurrence_client)->email }}</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card-content">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="card">
                                                    <div class="card-header">
                                                        <h3 class="box-title">Dados do cliente</h3>
                                                    </div>
                                                    <div class="card-content">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-8">
                                                                    <div class="form-group">
                                                                        <label>Nome completo do cliente</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="client_name" name="name" value="{{ old('name')? old('name') : optional($occurrence->occurrence_client)->name }}" placeholder="Nome completo do cliente" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>Número externo do cliente</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="client_number" name="client_number" value="{{ old('client_number')?  old('client_number') : optional($occurrence->occurrence_client)->client_number }}" placeholder="Nº cliente">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>E-mail</label>
                                                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email')?  old('email') : optional($occurrence->occurrence_client)->email }}" placeholder="email">
                                                                    </div>
                                                                </div>
                                                                <div class="col-4">
                                                                    <div class="form-group">
                                                                        <label>CPF ou CNPJ</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj')?  old('cpf_cnpj') : optional($occurrence->occurrence_client)->cpf_cnpj }}" placeholder="CPF ou CNPJ">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="divPhonePrincipal">
                                                                @foreach(optional($occurrence->occurrence_client)->occurrence_client_phones as $occurrence_client_phone)
                                                                    <div class="row">
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="phones">Telefone</label>
                                                                                <input type="text" class="form-control" id="phones" name="phones[]"
                                                                                       autocomplete="off" placeholder="Telefone" value="{{$occurrence_client_phone->phone}}" readonly>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <div class="form-group">
                                                                                <label for="Obs">Obs</label>
                                                                                <input type="text" class="form-control" id="obs" name="obs[]"
                                                                                       autocomplete="off" placeholder="Observação" value="{{ $occurrence_client_phone->obs }}" readonly>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <div class="divPhoneNew">
                                                            </div>
                                                            <div class="row add-phone" style="display: none;">
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
                                                                        <label>CEP</label>
                                                                        <div>
                                                                            <input type="text" autocomplete="off" class="form-control" style="width: calc(100% - 95px);display: inline-block; margin-right: 6px;" id="cep" name="cep" value="{{ old('cep')?  old('cep') : optional($occurrence->occurrence_client)->cep }}" placeholder="CEP" required>
                                                                            <a href="javascript:return void(0);" id="busca_cep" class="btn-sm btn-success right">Buscar</a>
                                                                            <i class="cs-loading" style="display:none;"></i>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-10">
                                                                    <div class="form-group">
                                                                        <label>Endereço</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="address" name="address" value="{{ old('address')?  old('address') : optional($occurrence->occurrence_client)->address }}" placeholder="Endereço" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label for="number">Nº</label>
                                                                        <input type="text" class="form-control" id="number" name="number"
                                                                               value="{{ (old('number'))? old('number') : optional($occurrence->occurrence_client)->number}}" autocomplete="off" placeholder="Nº">
                                                                    </div>
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-5">
                                                                    <div class="form-group">
                                                                        <label>Bairro</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="district" name="district" value="{{ old('district')?  old('district') : optional($occurrence->occurrence_client)->district }}" placeholder="Bairro" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-5">
                                                                    <div class="form-group">
                                                                        <label>Cidade</label>
                                                                        <input type="text" autocomplete="off" class="form-control" id="city" name="city" value="{{ old('city')?  old('city') : optional($occurrence->occurrence_client)->city }}" placeholder="Cidade" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-2">
                                                                    <div class="form-group">
                                                                        <label>Estado*</label>
                                                                        <select class="form-control select2" id="uf" name="uf" required data-placeholder="Estado">
                                                                            <option></option>
                                                                            @forelse(uf_list() as $key=>$value)
                                                                                <option value="{{$key}}" {{(optional($occurrence->occurrence_client)->uf==$key?"selected":"")}}>{{$value}} ({{$key}})</option>
                                                                            @empty
                                                                            @endforelse
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <label for="name">Zona</label>
                                                                    <p class="form-control-static" id="zone">{{optional($occurrence->zone)->zone}}</p>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="complement">Complemento</label>
                                                                        <input type="text" class="form-control" id="complement" name="complement"
                                                                               value="{{ (old('complement'))? old('complement') : optional($occurrence->occurrence_client)->complement}}" autocomplete="off"
                                                                               placeholder="Complemento">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <div class="form-group">
                                                                        <label for="reference">Referência</label>
                                                                        <input type="text" class="form-control" id="reference" name="reference"
                                                                               value="{{ (old('reference'))? old('reference') : optional($occurrence->occurrence_client)->reference}}" autocomplete="off"
                                                                               placeholder="Referência">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-12 d-flex justify-content-end">
                                                <button type="submit" class="btn btn-primary">Salvar</button>
                                                <a class="btn btn-link pull-right"
                                                   href="{{ route('occurrences.index') }}"><i
                                                        class="bx bx-arrow-back"></i> Voltar</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts2')
    <!-- Select2 -->
    {{--    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>--}}
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>

    <!-- Datepicker -->
    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script nonce="{{ csp_nonce() }}">


        $(function () {
            $(document).on("click", "#addPhone", function (e) {
                e.preventDefault();
                $('<div class="row">' +
                    '<div class="col-4">' +
                    '<div class="form-group">' +
                    '<label for="phone">Telefone</label>' +
                    '<input type="text" class="form-control phones" name="phones[]" autocomplete="off" placeholder="Telefone">' +
                    '</div>' +
                    '</div>' +
                    '<div class="col-4">' +
                    '<div class="form-group">' +
                    '<label for="Obs">Obs</label>' +
                    '<input type="text" class="form-control" name="obs[]" autocomplete="off" placeholder="Observação">' +
                    '<i class="bx bx-trash remove-row" style="position: absolute;right: -20px;bottom: 25px;"></i>' +
                    '</div>' +
                    '</div>' +
                    '</div>').appendTo(".divPhoneNew");
                return false;
            });
            $(document).on("click", ".remove-row", function () {
                $(this).parent().parent().parent().remove();
            });
            //Initialize Select2 Elements
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
                let clientNumber = (repo.client_number != null) ? repo.client_number + " | " : "";
                var $container = $(
                    "<option class='select2-result-repository__title' value=" + repo.id + ">" + clientNumber + repo.name + " | CPF/CNPJ: " + repo.cpf_cnpj + " | E-mail: " + repo.email + "</option>"
                );
                return $container;
            }

            function formatRepoSelection(repo) {
                // console.log("Repo: "+ JSON.stringify(repo));
                // return repo.name || repo.text;
                let clientNumber = (repo.client_number != null) ? repo.client_number + " | " : "";
                let valor_select = clientNumber + repo.name + " | CPF/CNPJ: " + repo.cpf_cnpj + " | E-mail: " + repo.email;
                if (repo.name != null) {
                    return valor_select;
                } else {
                    return repo.text;
                }
            }

            //AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO
            var $occurrence_client_id = $(".occurrence_client_id");
            var $uf = $("#uf").select2();

            $occurrence_client_id.on("select2:select", function (e) {
                var oc_id = $(this).val();

                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/occurrence_type/client_ajax/' + oc_id,
                    success: function (data) {
                        //Limpa os telefones anteriores
                        $(".divPhoneNew").html("");
                        $(".divPhonePrincipal").html("");

                        // var  data = data.data;

                        if (data.client_phones.length > 0) {
                            $.each(data.client_phones, function (index, object) {
                                $('<div class="row">' +
                                    '<div class="col-4">' +
                                    '<div class="form-group">' +
                                    '<label for="phone">Telefone</label>' +
                                    '<input type="text" autocomplete="off" readonly value="' + object.phone + '" class="form-control phones" placeholder="Telefone">' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-4">' +
                                    '<div class="form-group">' +
                                    '<label for="Obs">Obs</label>' +
                                    '<input type="text" autocomplete="off" value="' + object.obs + '" readonly class="form-control" placeholder="Observação">' +
                                    '<i class="bx bx-trash-o remove-row" style="position: absolute;right: 0;bottom: 10px;"></i>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>').prependTo(".divPhoneNew");
                            });
                        }

                        if (data == "") {
                            alert("Dados do usuário não encontrados");
                        } else {
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
                            $uf.val(data.uf).trigger("change").prop('disabled', true);
                            $("#complement").val(data.complement).prop('readonly', true);
                            $("#reference").val(data.reference).prop('readonly', true);
                        }
                        $(".add-phone").hide();
                        $("#busca_cep").hide();
                    }
                });

            });

            $occurrence_client_id.on("select2:unselect", function (e) {
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
                $uf.val("").trigger("change").prop('disabled', false);
                $("#complement").val("").prop('readonly', false);
                $("#reference").val("").prop('readonly', false);

                //remove telefones
                $(".divPhonePrincipal").html("");
                $(".divPhoneNew").html("");
                $(".add-phone").show();
                $("#busca_cep").show();
            });

            //FIM - AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO

            @if ($occurrence->occurrence_client_id)
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
            $uf.trigger("change").prop('disabled', true);
            $("#complement").prop('readonly', true);
            $("#reference").prop('readonly', true);
            @endif

            $('#input_alter_client').hide();
            $(".add-phone").hide();
            $("#busca_cep").hide();


            $('.date-picker').pickadate({
                formatSubmit: 'dd/mm/yyyy',
                format: 'dd/mm/yyyy',
                monthsFull: [
                    "Janeiro",
                    "Fevereiro",
                    "Março",
                    "Abril",
                    "Maio",
                    "Junho",
                    "Julho",
                    "Agosto",
                    "Setembro",
                    "Outubro",
                    "Novembro",
                    "Dezembro"
                ],
                monthsShort: [
                    "Jan",
                    "Fev",
                    "Mar",
                    "Abr",
                    "Ma",
                    "Jun",
                    "Jul",
                    "Agos",
                    "Set",
                    "Out",
                    "Nov",
                    "Dez"
                ],
                weekdaysShort: [
                    "D",
                    "S",
                    "T",
                    "Q",
                    "Q",
                    "S",
                    "S"
                ],
                today: 'Hoje',
                clear: 'Limpar',
                close: 'Fechar',
            });

        });
        //Show hide motive
        var $open_close = $("#open_close");
        $open_close.on("select2:select", function (e) {
            var oc_val = $(this).val();
            if (oc_val == 0) {
                $(".motive_div").show(300);
                $("#motive").prop("required", true);
                $(".nao_realizado").prop("required", true);
            } else {
                $(".motive_div").hide(300);
                $("#motive").prop("required", false);
                $(".nao_realizado").prop("required", false);
            }

        });

    </script>
    {{--BUSCA CEP--}}
    @include('helpers.busca_cep_helper')
@endsection
