@extends('layouts.frest_template')
@section('css')
    <!-- Select2 -->
    <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Usuário - {{ $user->name }} - Associar Clientes</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Usuário</li>
                        <li class="breadcrumb-item active">Associar Clientes</li>
                    </ol>
                </div>
            </div>

        </div>
    </div>

@endsection
@section('content')
    @include('messages')
    @include('error')

    <div class="form-body">
        <form class="form form-vertical" action="{{ route('users.associate.client.store', $user->uuid) }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title"><i class="bx bx-list-plus"></i>Adicionar Cliente</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Cliente</label>
                                <select class="form-control occurrence_client_id" id="occurrence_client_id" name="occurrence_client_id" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">Associar</button>
                                <a class="btn btn-link pull-right"
                                   href="{{ route('users.clients') }}"><i
                                        class="bx bx-arrow-back"></i> Voltar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //url: "/admin/occurrence_type/client_ajax",

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

                let clientNumber = (repo.client_number != null) ? " - (" + repo.client_number + ")" : "";

                return $(
                    "<option class='select2-result-repository__title' value=" + repo.id + ">" + repo.id + " - " + repo.name + clientNumber + "</option>"
                );
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
            }

            $occurrence_client_id.on("select2:select", function (e) {
                var oc_id = $(this).val();

                jQuery.ajax({
                    type: 'GET',
                    url: '/admin/occurrence_type/client_ajax/' + oc_id,
                    success: function (data) {

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
                            $("#zone").val(data.zone).prop('readonly', true);
                        }
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
                $("#zone").val("").prop('readonly', false);

                //remove telefones
                $(".divPhoneNew").remove();
            });

            //FIM - AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO

            @if (count($errors) > 0 && !empty(old('occurrence_client_id')))
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
            $("#zone").prop('readonly', true);
            @endif
        })
    </script>

@endsection
