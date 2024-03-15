@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Seções do tipo de ticket / Criar</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Seções do tipo de ticket</li>
                        <li class="breadcrumb-item active">Criar</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('messages')
    @include('error')
    <form action="{{ route('ticket_type_sections.store') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="ticket_type" value="{{ $ticketType}}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Seção</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Nome*</label>
                                        <input type="text" class="form-control" required name="name" value="{{ old('name') }}" placeholder="Nome" autocomplete="off">
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="name">Descrição</label>
                                        <textarea class="form-control" name="description" placeholder="Descrição" autocomplete="off" rows="8">{{ old('description') }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include("form_sections.includes.adicionar_campos", ["edit"=>false])

        <div class="row">
            <div class="col-12 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary">Criar</button>
                <a class="btn btn-link pull-right"
                   href="{{ route('ticket_types.show', $ticketType->uuid) }}"><i
                        class="bx bx-arrow-back"></i> Voltar</a>
            </div>
        </div>
    </form>

@endsection
@section('scripts')
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="/bower_components/AdminLTE/plugins/select2/select2.full.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            $('#typeFieldItem').on('change', function() {
                let typeField = $(this).val();

                if (typeField == 3 || typeField == 1 || typeField == 6) {
                    $("#listOptions").html('');
                    $("#radioOptions").show();
                    $("#listOptions").show();
                } else {
                    $("#radioOptions").hide();
                    $("#listOptions").hide();
                    $("#listOptions").html('');
                }
            });

            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
            });

            $( "#addItem" ).click(function(event) {
                event.preventDefault();

                let nameItem = $("#nameItem").val();
                let descriptionItem = $("#descriptionItem").val();
                let typeFieldItemValue = typeForm($("#typeFieldItem").val());
                let typeFieldItem = $("#typeFieldItem").val();
                let requiredItem = simNao($("#requiredItem").val());
                let requiredItemId = $("#requiredItem").val();
                let picAmount = $("#picAmount").val();
                let picAmountId = $("#picAmount").val();

                if (nameItem == "" || descriptionItem == "" || typeFieldItemValue == "" || typeFieldItem == "" || requiredItemId == "" || picAmount == "") {
                    swal("Atenção!", "Preencha os campos.", "error");
                    return false;
                }

                if (typeFieldItem == 3 || typeFieldItem == 1 || typeFieldItem == 6) {
                    if($('#answers-container').find('.respostaItem').length == 0){
                        swal("Atenção!", "Adicione pelo menos uma resposta", "error");
                        return false;
                    }
                }

                let itemOption = "";
                let itenSend = "";

                if ($("#typeFieldItem").val() == 3 || $("#typeFieldItem").val() == 1 || $("#typeFieldItem").val() == 6) {

                    itemOption += "<div class=\"form-group  col-md-12\">";
                    itemOption += "<div > <b>Respostas: </b></div>";

                    $('#answers-container').find('.respostaItem').each(function () {
                        itemOption += '<div class="row" >\n' +
                            '                    <div class="form-group  col-md-6" id="nameItem">\n' +
                            '                        <input type="text" readonly class="form-control respostaItem" name="itemRadioExibicao" value="' + $(this).val() + '" placeholder="Resposta" autocomplete="off">\n' +
                            '                    </div>\n' +
                            '                </div>';
                        itenSend += $(this).val() + ";";
                    });
                    itemOption += "</div>";
                }

                var item = '<div><div class="row" >\n' +
                    '                    <input type="hidden" readonly class="form-control" name="lists_answers[]" value="'+itenSend+'" >\n' +
                    '                    <div class="form-group  col-md-3" id="nameItem">\n' +
                    '                        <label for="name">Nome</label>\n' +
                    '                        <input type="text" readonly class="form-control" name="nameItem[]" value="'+nameItem+'" placeholder="Nome" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-md-3">\n' +
                    '                        <label for="name">Descrição</label>\n' +
                    '                        <input type="text" readonly class="form-control" name="descriptionItem[]" value="'+descriptionItem+'" placeholder="Nome" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-md-1">\n' +
                    '                        <label for="name">Tipo</label>\n' +
                    '                        <input type="text" readonly class="form-control" name="typeFieldItem[]" value="'+typeFieldItemValue+'" placeholder="Nome" autocomplete="off">\n' +
                    '                        <input type="hidden" readonly class="form-control" name="typeFieldItemId[]" value="'+typeFieldItem+'" placeholder="Nome" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-md-2">\n' +
                    '                        <label for="name">Obrigatório ?</label>\n' +
                    '                        <input type="text" readonly class="form-control" name="requiredItem[]" value="'+requiredItem+'" placeholder="Nome" autocomplete="off">\n' +
                    '                        <input type="hidden" readonly class="form-control" name="requiredItemId[]" value="'+requiredItemId+'" placeholder="Nome" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-md-2">\n' +
                    '                        <label for="name">MIN. FOTOS OBRIGATÓRIAS?</label>\n' +
                    '                        <input type="text" readonly class="form-control" name="picAmount[]" value="'+picAmount+'" placeholder="Nome" autocomplete="off">\n' +
                    '                        <input type="hidden" readonly class="form-control" name="picAmountId[]" value="'+picAmountId+'" placeholder="Nome" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-md-1">\n' +
                    '                        <label>&nbsp;</label>\n' +
                    '                        <div>\n' +
                    '                            <span class="btn btn-danger cursor-pointer" id="removeItem" title="Remover" onclick="removeItem(this)"><i class="bx bx-minus"></i></span>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    itemOption +

                    '</div><hr></div>';

                $("#listItens").append(item);

                $("#nameItem").val('');
                $("#descriptionItem").val('');
                $("#typeFieldItem").select2().val('').trigger("change");
                $("#requiredItem").select2().val('').trigger("change");
                $("#picAmount").select2().val('').trigger("change");

                $("#listOptions").html('');
            });

            $( "#addResposta" ).click(function(event) {
                event.preventDefault();

                let respostaItem = $("#respostaItem").val();
                respostaItem = respostaItem.replace(/[,; ]+/g, " ").trim();

                $("#respostaLabel").show();

                if (respostaItem == "") {
                    swal("Atenção!", "Preencha a resposta.", "error");
                    return false;
                }

                $("#respostaItem").val('');

                var itemOption = '<div class="row" >\n' +
                    '                    <div class="form-group  col-6" id="nameItem">\n' +
                    '                        <label for="name">&nbsp;</label>\n' +
                    '                        <input type="text" readonly class="form-control respostaItem" name="respostas" value="'+respostaItem+'" placeholder="Resposta" autocomplete="off">\n' +
                    '                    </div>\n' +
                    '\n' +
                    '                    <div class="form-group  col-3">\n' +
                    '                        <label>&nbsp;</label>\n' +
                    '                        <div>\n' +
                    '                            <span class="btn btn-danger" id="removeItemOption" title="Remover" onclick="removeItemOption(this)"><i class="bx bx-minus"></i> Remover</span>\n' +
                    '                        </div>\n' +
                    '                    </div>\n' +
                    '                </div>';

                $("#listOptions").append(itemOption);
            });


        });


        function removeItem(object) {
            $(object).parent().parent().parent().parent().remove();
        }

        function typeForm(tipo_id) {
            if (tipo_id == 1) {
                return "Checkbox";
            } else if (tipo_id == 2) {
                return "Texto";
            } else if (tipo_id == 3) {
                return "Radio";
            } else if (tipo_id == 4) {
                return "Número";
            } else if (tipo_id == 5) {
                return "Imagem";
            }else if (tipo_id == 6) {
                return "Seleção";
            }else if (tipo_id == 7) {
                return "Assinatura";
            }
        }

        function simNao(id) {
            if (id == 1) {
                return "Sim";
            } else if (id == 2) {
                return "Não";
            }
        }

        function removeItemOption(object) {
            $(object).parent().parent().parent().remove();
        }
    </script>

@endsection
