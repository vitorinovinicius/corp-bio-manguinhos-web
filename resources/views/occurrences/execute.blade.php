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
                <h5 class="content-header-title float-left pr-1 mb-0">Ordem de Serviço / Executar #{{$occurrence->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Ordem de Serviço</li>
                        <li class="breadcrumb-item active">Executar</li>
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
            <form class="form form-vertical" action="{{ route('occurrences.execute.create', $occurrence->uuid) }}" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="chekin" value="{{ Carbon\Carbon::now() }}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <div class="form-body">
                    <div class="row">

                        <div class="col-12">
                            @include("occurrences.includes.occurrence")
                            @include("occurrences.includes.dados_cliente")
                            {{--                            @include("occurrences.execute.data_os")--}}
                            @include("occurrences.execute.data_cliente")

                            @include("occurrences.execute.dinamic_form")
                            @include("occurrences.execute.interference")
                            @include("occurrences.execute.obs_gerais")

                        </div>
                    </div>

                    <div class="">
                        <div class="col-12 d-flex justify-content-end">
                            <button type="submit" class="btn btn-primary">Salvar</button>
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


            $('#cliente_acompanha').change(function(){
                var value = $(this).val();
                if(value == 2){
                    var phone = {!!optional($occurrence->occurrence_client)->occurrence_client_phones!!};
                    var sPhone = '';
                    phone.map(function(phone){
                        sPhone += phone.phone +',';
                    });

                    $("#outros").prop('readonly', true);
                    $("#cliente_nome").val('{!!optional($occurrence->occurrence_client)->name!!}').prop('readonly', true);
                    $("#cliente_email").val('{!!optional($occurrence->occurrence_client)->email!!}').prop('readonly', true);
                    $("#cliente_cpf").val('{!!optional($occurrence->occurrence_client)->cpf_cnpj!!}').prop('readonly', true);
                    $("#cliente_telefone").val(sPhone.substr(0, sPhone.length -1)).prop('readonly', true);

                } else {

                    $("#outros").val("").prop('readonly', false);
                    $("#cliente_nome").val("").prop('readonly', false);
                    $("#cliente_email").val("").prop('readonly', false);
                    $("#cliente_cpf").val("").prop('readonly', false);
                    $("#cliente_telefone").val("").prop('readonly', false);
                }
            })
            //AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO
            var $occurrence_client_id = $(".occurrence_client_id");
            var $uf = $("#uf").select2();

            $cliente_acompanha.on("select2:select", function (e) {
                var oc_id = $(this).val();

                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/occurrence_type/client_ajax/'+oc_id,
                    success: function( data )
                    {
                        //Limpa os telefones anteriores
                        $(".divPhoneNew").html("");
                        $(".divPhonePrincipal").html("");

                        // var  data = data.data;

                        if (data.client_phones.length > 0) {
                            $.each(data.client_phones, function(index, object) {
                                $('<div class="row">' +
                                    '<div class="col-4">' +
                                    '<div class="form-group">' +
                                    '<label for="phone">Telefone</label>' +
                                    '<input type="text" autocomplete="off" readonly value="'+object.phone+'" class="form-control phones" placeholder="Telefone">' +
                                    '</div>' +
                                    '</div>' +
                                    '<div class="col-4">' +
                                    '<div class="form-group">' +
                                    '<label for="Obs">Obs</label>' +
                                    '<input type="text" autocomplete="off" value="'+object.obs+'" readonly class="form-control" placeholder="Observação">' +
                                    '<i class="bx bx-trash-o remove-row" style="position: absolute;right: 0;bottom: 10px;"></i>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>').prependTo(".divPhoneNew");
                            });
                        }

                        if(data == ""){
                            alert("Dados do usuário não encontrados");
                        }else{
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


            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });


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
@endsection
