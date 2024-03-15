<?php

    if (isset($_GET["dt_i"]) && !empty($_GET["dt_i"])) {
        $dt_i = app('request')->input('dt_i');
    } else {
        $dt_i = date("d/m/Y", strtotime("-30 days"));
    }
    if (isset($_GET["dt_f"]) && !empty($_GET["dt_f"])) {
        $dt_f = app('request')->input('dt_f');
    } else {
        $dt_f = date("d/m/Y");
    }
    $qtd_os = teams_os_realizadas($team->id, $dt_i, $dt_f);
?>

@extends('layouts.frest_template')
@section('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.0/css/bootstrap-datepicker.css" rel="stylesheet">
    <link href="https://docs.dhtmlx.com/gantt/codebase/dhtmlxgantt.css?v=7.1.8" rel="stylesheet">
    <link href="/schedule-master/dist/css/style.min.css" rel="stylesheet">
    <style>
        #list-os {
            border: 1px solid #cccccc;
            border-radius: 4px;
            padding: 15px;
        }

        .box {
            background-color: #4f93d6;
            border-radius: 5px;
            width: 100%;
            color: #cccccc;
            margin-bottom: 5px;
            padding: 5px;
        }

        .sc_bar {
            margin-bottom: 3px;
        }

        .jq-schedule .sc_menu .sc_header .sc_time,
        .jq-schedule .sc_menu .sc_header_cell, .jq-schedule .sc_data {
            font-weight: normal;
            background-color: #fafbfb !important;
            color: #727E8C;
            font-family: "Rubik", Helvetica, Arial, serif;
        }

        .jq-schedule .timeline, .jq-schedule .sc_main .tb {
            border-bottom: solid 2px #dfe3e7 !important;
        }

    </style>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Equipes / Exibir #{{$team->id}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Equipes</li>
                        <li class="breadcrumb-item active">Exibir</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        <form action="{{ route('teams.destroy', $team->uuid) }}" method="POST" style="display: inline;" onsubmit="if(confirm('Deseja realmente excluir esse item?')) { return true } else {return false };">
            <input type="hidden" name="_method" value="DELETE">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="btn-group pull-right" role="group" aria-label="...">
                @shield('team.edit')
                <a class="btn btn-warning btn-group" role="group" href="{{ route('teams.edit', $team->uuid) }}"><i class="bx bx-edit"></i> Editar</a>
                @endshield
                @shield('team.destroy')
                <button type="submit" class="btn btn-danger">Excluir <i class="bx bx-trash"></i></button>
                @endshield
            </div>
        </form>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Dados da Equipe</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-1">
                                <div class="form-group">
                                    <label for="name">ID</label>
                                    <p class="form-control-static">{{$team->id}}</p>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="name">Nome</label>
                                    <p class="form-control-static">{{$team->name}}</p>
                                </div>
                            </div>
                            <div class="col-5">
                                <div class="form-group">
                                    <label for="name">Supervisor</label>
                                    <p class="form-control-static">{{ $team->users()->wherePivot('is_supervisor',1)->get()->implode('name', ' | ') }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="name">Bairros de Atuação</label>
                                    <p class="form-control-static">{!!  nl2br($team->district) !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            @if($team->users()->count())
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="box-title">Membros</h3>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped table-sm table-hover" data-order='[[ 0, "desc" ]]' data-page-length='25'>
                                            <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Nome</th>
                                                <th>email</th>
                                                <th>Equipe</th>
                                                <th>Tipo</th>
                                                <th>Última conexão</th>

                                                <th class="text-right hidden-print">OPÇÕES</th>
                                            </tr>
                                            </thead>

                                            <tbody>
                                            @foreach($team->users()->distinct()->get() as $operator)
                                                <tr>
                                                    <td>{{$operator->id}}</td>
                                                    <td>{{$operator->name}}</td>
                                                    <td>{{$operator->email}}</td>
                                                    <td>{{$operator->teams[0]->name}}</td>
                                                    <td>
                                                        @foreach($operator->user_teams()->where("team_id","=",$team->id)->get() as $user_team)
                                                            <span class="badge badge-primary">{{($user_team->is_supervisor == 1 ? "Supervisor" : "Operador")}}</span>
                                                        @endforeach
                                                    </td>
                                                    <td class="text-center">{{(!empty($operator->last_connection))? date('d/m/Y H:i:s', strtotime($operator->last_connection)) : "-"}}</td>

                                                    <td class="text-right hidden-print">
                                                        @is(['admin','superuser','supervisor'])
                                                        <a href="{{ route('operators.show', $operator->uuid) }}" class="btn btn-icon btn-sm btn-primary" data-toggle="tooltip" data-placement="left" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                        @endis
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="box-title">Cronograma da Equipe</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="cs_timeline">
                            <form class="form form-vertical form_export" method="GET">
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Data dos agendamentos</label>
                                                <input type="date" class="form-control" id="schedule_date_search" name="schedule_date" value="{{ app('request')->input('schedule_date') }}">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Tipos de OS</label>
                                                <select class="form-control select2" name="occurrence_type_id" data-placeholder="Tipos de OS">
                                                    <option></option>
                                                    @foreach(App\Models\OccurrenceType::all() as $occurrenceType)
                                                        <option value="{{$occurrenceType->id}}" {{(app('request')->input('occurrence_type_id') == $occurrenceType->id ?"selected":"")}}>{{$occurrenceType->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <br>
                                            <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                            <a href="{{ route('teams.show', $team->uuid) }}" class="btn btn-link"><i class="bx bx-eraser"></i> Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="" id="schedule">
                                        {{-- <div class="col-md-2" id="list-os">
                                            <h5>OSs nao atribuídas</h5>
                                            <div  class="box sc_bar" id="box1">
                                                <span class="head"><span class="time">09:00-12:00</span></span>
                                                <span class="text">Text Area</span>
                                            </div>
                                            <div  class="box">B</div>
                                            <div  class="box">C</div>
                                        </div> --}}
                                        <div class="jq-schedule col-md-10">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="addOS" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Cadastro de OS</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="form form-vertical" id="form-add-OS">
                    <div class="modal-body">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-header">
                                            <h3 class="box-title">Dados da OS</h3>
                                        </div>
                                        <div class="card-content">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Número OS</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="numero_os" name="numero_os" value="{{ old('numero_os') }}" placeholder="Número OS">
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Data do agendamento*</label>
                                                            <input type="date" autocomplete="off" class="form-control" id="schedule_date" name="schedule_date" value="{{ old('schedule_date') }}" placeholder="Data do agendamento" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Hora do agendamento</label>
                                                            <input type="time" autocomplete="off" class="form-control" id="schedule_time" name="schedule_time" value="{{ old('schedule_time') }}" placeholder="Hora do agendamento">
                                                        </div>
                                                    </div>
                                                    <div class="col-3
                                        2">
                                                        <div class="form-group">
                                                            <label>Turno</label>
                                                            <select class="form-control select2" name="shift" data-placeholder="Turno">
                                                                <option></option>
                                                                <option value="1" {{(old('shift')==1?"selected":"")}}>Manhã</option>
                                                                <option value="2" {{(old('shift')==2?"selected":"")}}>Tarde</option>
                                                                <option value="3" {{(old('shift')==3?"selected":"")}}>Noite</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Prioridade*</label>
                                                            <select class="form-control select2" name="priority" required data-placeholder="Prioridade">
                                                                <option></option>
                                                                @forelse(priority_list_array() as $key=>$value)
                                                                    <option value="{{$key}}" {{(old('priority')==$key?"selected":"")}}>{{$value}}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Tipo da Ocorrência*</label>
                                                            <select class="form-control select2" name="occurrence_type_id" data-placeholder="Selecione o tipo da Ocorrência">
                                                                <option></option>
                                                                @forelse(App\Models\OccurrenceType::all() as $ot)
                                                                    <option value="{{$ot->id}}" {{(old('occurrence_type_id')==$ot->id?"selected":"")}}>{{$ot->name}}</option>
                                                                @empty
                                                                @endforelse
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group">
                                                            <label>Cliente</label>
                                                            <select class="form-control occurrence_client_id select2" id="occurrence_client_id" name="occurrence_client_id">
                                                                <option></option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                            <input type="text" autocomplete="off" class="form-control" id="client_name" name="name" value="{{ old('name') }}" placeholder="Nome completo do cliente" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>Número externo do cliente</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="client_number" name="client_number" value="{{ old('client_number') }}" placeholder="Nº cliente" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>E-mail</label>
                                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="email" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>CPF ou CNPJ</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="cpf_cnpj" name="cpf_cnpj" value="{{ old('cpf_cnpj') }}" placeholder="CPF ou CNPJ" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-4">
                                                        <div class="form-group">
                                                            <label>CEP</label>
                                                            <div>
                                                                <input type="text" autocomplete="off" class="form-control" id="cep" name="cep" value="{{ old('cep') }}" placeholder="CEP" required readonly>
                                                                <i class="cs-loading" style="display:none;"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-10">
                                                        <div class="form-group">
                                                            <label>Endereço</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="address" name="address" value="{{ old('address') }}" placeholder="Endereço" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-2">
                                                        <div class="form-group">
                                                            <label for="number">Nº</label>
                                                            <input type="text" class="form-control" id="number" name="number"
                                                                   value="{{ old('number') }}" autocomplete="off" placeholder="Nº"
                                                                   required readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Bairro</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="district" name="district" value="{{ old('district') }}" placeholder="Bairro" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Cidade</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="city" name="city" value="{{ old('city') }}" placeholder="Cidade" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label>Estado*</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="uf" name="uf" value="{{ old('uf') }}" placeholder="Cidade" required readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <div class="form-group">
                                                            <label for="zone">Zona</label>
                                                            <input type="text" autocomplete="off" class="form-control" id="zone_id" name="zone_id" value="{{ old('uf') }}" placeholder="Cidade" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="complement">Complemento</label>
                                                            <input type="text" class="form-control" id="complement" name="complement"
                                                                   value="{{ old('complement') }}" autocomplete="off"
                                                                   placeholder="Complemento" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group">
                                                            <label for="reference">Referência</label>
                                                            <input type="text" class="form-control" id="reference" name="reference"
                                                                   value="{{ old('reference') }}" autocomplete="off"
                                                                   placeholder="Referência" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary" id="send-os">Salvar</button>
                    </div>
            </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.min.js"></script> --}}
    <script src="/schedule-master/dist/js/jq.schedule.min.js"></script>



    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>

    <script nonce="{{ csp_nonce() }}">

        $('.date-picker').datepicker({
            format: 'dd/mm/yyyy',
            language: 'pt-BR',
            weekStart: 0,
            endDate: '0d',
            todayHighlight: true,
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior'
        });

        function addLog(type, message) {
            var $log = $('<tr />');
            $log.append($('<th />').text(type));
            $log.append($('<td />').text(message ? JSON.stringify(message) : ''));
            $("#logs table").prepend($log);
        }


        const data = {!! $dataString !!}

        $("#schedule").timeSchedule({
            resizable: false,
            rows: {!! $dataString !!},
            onAppendSchedule: function (node, data) {
                addLog('onAppendSchedule', data);
                if (data.data.class) {
                    node.addClass(data.data.class);
                }
            },
            onScheduleClick: function (node, time, timeline) {
                var el = '<input type="hidden" name="operator_id" value=' + timeline + '></input>';
                $('#form-add-OS').append(el);
                $('#schedule_time').val(time);
                $('#schedule_date').val($('#schedule_date_search').val());

                $('#addOS').modal('show');

                $('#send-os').click(function () {
                    var formData = $('#form-add-OS').serialize();

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        }
                    }),
                        jQuery.ajax({
                            type: 'POST',
                            url: '{{route("occurrences.store.ajax")}}',
                            data: formData,

                            success: function (data) {
                                if (data.retorno == 2) {
                                    alert(data.mensagem);
                                } else {
                                    alert(data.mensagem);
                                    location.reload();
                                }
                            },
                            error: function () {
                                alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                            }
                        });
                    return false;
                });
                // var start = time;
                // var end = $(this).timeSchedule('formatTime', $(this).timeSchedule('calcStringTime', time) + 3600);
                // $(this).timeSchedule('addSchedule', timeline, {
                //     start: start,
                //     end: end,
                //     text:'Insert Schedule',
                //     data:{
                //         class: 'sc_bar_insert'
                //     }
                // });
                // addLog('onScheduleClick', time + ' ' + timeline);
            },
            onChange: function (node, time, timeline) {
                console.log(node, time, timeline)
                const dataValues = Object.values(data);
                const timelineOperator = time.timeline;
                const {occurrence_id, operator_id} = time.data;
                const operator = dataValues[timelineOperator].operator_id;
                const {start, end} = time;

                const newOperator = (operator_id == operator) ? operator_id : operator;

                jQuery.ajax({
                    type: 'POST',
                    url: '{{route("occurrences.update.ajax")}}',
                    data: {
                        'occurrence_id': occurrence_id,
                        'operator_id': newOperator,
                        'schedule_time': start,
                        "_token": "{{ csrf_token() }}",
                    },

                    success: function (data) {
                        if (data.retorno == 2) {
                            alert(data.mensagem);
                        } else {
                            alert(data.mensagem);
                            // location.reload();
                        }
                    },
                    error: function () {
                        alert("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });
            },

        });

        $("#box1").draggable({
            stop: function (event, ui) {
                console.log(event);
                document.addEventListener('click', function () {

                });

            }
        });

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

                var $container = $(
                    "<option class='select2-result-repository__title' value=" + repo.id + ">" + repo.id + " - " + repo.name + clientNumber + "</option>"
                );

                return $container;
            }

            function formatRepoSelection(repo) {
                return repo.name || repo.text;
                ;
            }
        });

        //AJAX E PREENCHIMENTO AUTOMÁTICO DOS DADOS DO USUARIO
        var $occurrence_client_id = $(".occurrence_client_id");
        //var $uf = $("#uf").select2();

        $occurrence_client_id.on("select2:select", function (e) {
            var oc_id = $(this).val();

            jQuery.ajax({
                type: 'GET',
                url: '/admin/occurrence_type/client_ajax/' + oc_id,
                success: function (data) {
                    //Limpa os telefones anteriores

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
        $("#complement").prop('readonly', true);
        $("#reference").prop('readonly', true);
        $("#zone").prop('readonly', true);
        @endif


    </script>
@endsection
