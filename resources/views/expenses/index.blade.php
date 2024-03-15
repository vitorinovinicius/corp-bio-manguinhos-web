@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="{{asset('/bower_components/AdminLTE/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
    <style nonce="{{ csp_nonce() }}">
        @media (min-width: 992px) {
            .cs-col-md-1 {
                max-width: 14.28% !important;
                width: 14.28% !important;
                flex: 0 0 14.28%;
            }

            .card-content-card {
                height: 280px !important;
            }
        }

        .padding-tb-5 {
            padding-top: 5px;
            padding-bottom: 5px;
        }
    </style>
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Despesas</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Despesa</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
        @shield('expense.create')
        <a href="{{route('expense.create')}}" class="btn btn-primary">Lançar despesas</a>
        @endshield

        {{-- @shield('repayment.create')
        <a class="btn btn-success pull-right" href="{{ route('repayment.create') }}"><i class="bx bx-plus"></i> Novo</a>
        @endshield --}}
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
                <div class="card-content collapse {{app('request')->exists('name') == false ? "" : "show" }}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="name">Período</label>
                                            <input type="text" class="form-control daterange" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
                                        </div>
                                    </div>
                                    @is('superuser')
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" data-placeholder="Selecione uma empreiteira">
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}">{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select class="form-control select2" name="operator_id" id="operator_id" data-placeholder="Técnico">
                                                <option></option>
                                                @if($operators)
                                                    @foreach ($operators as $operator)
                                                        <option value="{{$operator->id}}" {{(app('request')->input('operator_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2" name="status" id="" data-placeholder="Selecione um status">
                                                <option></option>
                                                <option value="1" {{(app('request')->input('status')==1?"selected":"")}}>Pendente</option>
                                                <option value="2" {{(app('request')->input('status')==2?"selected":"")}}>Pago</option>
                                                <option value="3" {{(app('request')->input('status')==3?"selected":"")}}>Recusado</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div>
                                        <br>
                                        <button type="submit" class="btn btn-primary pull-righ" id="btn-external-filter">Aplicar</button>
                                        <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-link pull-right"><i class="bx bx-eraser"></i> Limpar</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--FILTROS FIM--}}

    <div class="row">
        <div class="col-12 mt-1 mb-2">
            <h4>Monitoramento de despesa</h4>
            <hr>
        </div>
    </div>

    <div class="d-flex justify-content-center ">

        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index")}}">
                <div class="card text-center">
                    <div class="card-content card-content-card">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-info mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Total de despesas</p>
                            <h2 class="mb-0 box_total_os">{{$total}}</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" style="width: {{($total>0)? number_format((float)(($paidOut + $refused) / $total)*100, 2, '.', '') : "0"}}%" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_total_percent">{{($total>0)? number_format((float)(($paidOut + $refused) / $total)*100, 2, '.', '') : "0"}}% pagas </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index")}}">
                <div class="card text-center">
                    <div class="card-content card-content-card">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-success mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Pagas</p>
                            <h2 class="mb-0 box_total_os">{{$paidOut}}</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" style="width: {{($total>0)? number_format((float)($paidOut / $total)*100, 2, '.', '') : "0"}}%" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_total_percent">{{($total>0)? number_format((float)($paidOut / $total)*100, 2, '.', '') : "0"}}% do total </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index")}}">
                <div class="card text-center">
                    <div class="card-content card-content-card">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-warning mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Pendentes</p>
                            <h2 class="mb-0 box_total_os">{{$pending}}</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" style="width: {{($total>0)? number_format((float)($pending / $total)*100, 2, '.', '') : "0"}}%" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_total_percent">{{($total>0)? number_format((float)($pending / $total)*100, 2, '.', '') : "0"}}% do total </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index")}}">
                <div class="card text-center">
                    <div class="card-content card-content-card">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-danger mx-auto my-1">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Recusadas</p>
                            <h2 class="mb-0 box_total_os">{{$refused}}</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" style="width: {{($total>0)? number_format((float)($refused / $total)*100, 2, '.', '') : "0"}}%" role="progressbar"></div>
                            </div>
                            <span class="progress-description box_total_percent">{{($total>0)? number_format((float)($refused / $total)*100, 2, '.', '') : "0"}}% do total </span>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-md-2 cs-col-md-2 padding-5 padding-tb-5">
            <a href="{{route("occurrences.index")}}">
                <div class="card text-center">
                    <div class="card-content card-content-card">
                        <div class="card-body">
                            <div class="badge-circle badge-circle-lg badge-circle-light-primary mx-auto my-1" style="color: #000000 !important;">
                                <i class="bx bx-file font-medium-5"></i>
                            </div>
                            <p class="text-muted mb-0 line-ellipsis">Inválidas</p>
                            <h2 class="mb-0 box_total_os">{{$inactive}}</h2>
                            <div class="progress progress-bar-info mb-1 mt-1">
                                <div class="progress-bar  progress-bar-animated box_total_progress" style="width: {{($total>0)? number_format((float)($inactive / $total)*100, 2, '.', '') : "0"}}% style=" background-color: rgb(0, 0, 0); box-shadow: rgba(0, 0, 0, 0.6) 0px 2px 6px 0px; width: 0%;
                                "" role="progressbar" >
                            </div>
                        </div>
                        <span class="progress-description box_total_percent">{{($total>0)? number_format((float)($inactive / $total)*100, 2, '.', '') : "0"}}% do total </span>
                    </div>
                </div>
        </div>
        </a>
    </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h3 class="box-title">Reembolso</h3>
                        @shield('expense.status')
                        <select name="" id="inAll" class="form-control col-2">
                            <option value="">Atualização em massa</option>
                            <option value="2">Paga</option>
                            <option value="1">Pendente</option>
                            <option value="3">Recusada</option>
                            <option value="4">Inválida</option>
                        </select>
                        @endshield
                    </div>

                </div>
                <div class="card-content">
                    <div class="card-body">
                        @if($expenses->count())
                            <div>
                                <table class="table table-condensed table-striped table-sm">
                                    <thead>
                                    <tr>
                                        <td></td>
                                        <th>ID</th>
                                        @is('superuser')
                                        <th>Empreiteira</th>
                                        @endis
                                        <th>Técnico</th>
                                        <th>Valor</th>
                                        <th>Data
                                            <i class="text-reset bx bx-help-circle" title="Data lançamento da despesa no sistema" style="font-size: small"></i>
                                        </th>
                                        <th>Tipo de despesa</th>
                                        <th>Status</th>
                                        <th class="text-right">OPÇÕES</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    @foreach($expenses as $expense)
                                        <tr>
                                            <td>
                                                <div class="checkbox checkbox-primary">
                                                    <input class="checkbox-input" type="checkbox" name="expense" value="{{$expense->id}}" id="checkbox_{{$expense->id}}">
                                                    <label class="form-check-label" for="checkbox_{{$expense->id}}" style="margin-left: 7px;">
                                                    </label>
                                                </div>
                                            </td>
                                            <td>{{$expense->id}}</td>
                                            @is('superuser')
                                            <td>{{optional($expense->contractor)->name}}</td>
                                            @endis
                                            <td>{{optional($expense->user)->name}}</td>
                                            <td>{{number_format((float)$expense->value, 2, ',', '.')}}</td>
                                            <td>{{$expense->dateFormat()}}</td>
                                            <td>{{optional($expense->expenseTypes)->name}}</td>
                                            <td>
                                                <span
                                                    class=
                                                    @if($expense->status == 1)
                                                        'text-warning'
                                                    @elseif($expense->status == 2)
                                                        'text-success'
                                                    @elseif($expense->status == 3)
                                                        'text-danger'
                                                    @else
                                                        'text-secondary'
                                                    @endif
                                                >

                                                    @if($expense->status == 1)
                                                        Pendente
                                                    @elseif($expense->status == 2)
                                                        Pago
                                                    @elseif($expense->status == 3)
                                                        Recusado
                                                    @else
                                                    Inválida
                                                    @endif
                                                </span>
                                            </td>
                                            <td class="text-right">
                                                <div class="d-flex justify-content-end">
                                                    @shield('expense.show')
                                                    <a href="{{ route('expense.show', $expense->uuid) }}" class="btn btn-icon btn-sm btn-primary mr-1" data-toggle="tooltip" title="Exibir"><i class="bx bx-book-open"></i></a>
                                                    @endshield

                                                    @shield('expense.edit')
                                                    <a href="{{ route('expense.edit', $expense->uuid) }}" class="btn btn-icon btn-sm btn-warning mr-1" data-toggle="tooltip" title="Editar"><i class="bx bx-pencil"></i></a>
                                                    @endshield
                                                    @shield('expense.destroy')
                                                    <form action="{{ route('expense.destroy', $expense->uuid) }}"
                                                          method="POST" style="display: inline;"
                                                          onsubmit="if(confirm('Deseja deletar esse item?')) { return true } else {return false };">
                                                        <input type="hidden" name="_method" value="DELETE">
                                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                                        <button type="submit" class="btn btn-icon btn-sm btn-danger" data-toggle="tooltip" title="Deletar">
                                                            <i class="bx bx-trash"></i></button>
                                                    </form>
                                                    @endshield

                                                    @shield('expense.status')
                                                    <select name="status" data-id="{{$expense->id}}" class="status form-control form-control-sm col-4 ml-1">
                                                        <option value="">Status</option>
                                                        <option value="2">Paga</option>
                                                        <option value="1">Pendente</option>
                                                        <option value="3">Recusada</option>
                                                        <option value="4">Inválida</option>
                                                    </select>
                                                    @endshield
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {!! $expenses->render() !!}
                        @else
                            <h3 class="text-center alert alert-info">Vazio!</h3>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('/bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function () {
            //Initialize Select2 Elements
            $(".select2").select2({
                allowClear: true,
                width: "100%"
            });
        });

        $(function () {
            $('.daterange').daterangepicker({
                autoApply: false,
                autoUpdateInput: false,
//                maxDate: moment(),
                locale: {
                    format: 'DD/MM/YYYY',
                    cancelLabel: 'Limpar',
                    applyLabel: "Ok",
                    fromLabel: "De",
                    toLabel: "Até",
                    daysOfWeek: [
                        "D",
                        "S",
                        "T",
                        "Q",
                        "Q",
                        "S",
                        "S"
                    ],
                    monthNames: [
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
                },
            });

            $('.daterange').on('apply.daterangepicker', function (ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterange').on('cancel.daterangepicker', function (ev, picker) {
                $(this).val('');
            });
        });

        $('.status').change(function () {

            var status = $(this).val();
            var id = $(this).attr('data-id');

            var input;

            if(status == 3){

                input = {
                    element: "input",
                    attributes: {
                        placeholder: "Informe o motivo do cancelamento",
                        type: "textarea",
                    },
                }
            }

            swal({
                text: "Deseja realmente alterar o status da despesa?",
                content:input,
                buttons: true,

            }).then(motivo => {

                if(motivo == null){
                   return false;
                }
                motivo = (motivo == true) ? "" : motivo;
                $.ajax({
                    headers: {
                        'X-CSRF-Token': $('input[name="_token"]').val()
                    },
                    type: "POST",
                    url: '{{route("expense.status")}}',
                    data: {
                        id: id,
                        status: status,
                        cancellation_reason: motivo
                    },
                    success: function (data) {
                        swal({
                            title: "Bom trabalho!", text: data.mensagem, type: "success"
                        }).then(() => {
                            location.reload();
                        });
                    },
                    error: function () {
                        swal("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                    }
                });

            });

        });



        $("#inAll").change(function () {
            var expenses = [];
            $("input:checkbox[name=expense]:checked").each(function () {
                expenses.push($(this).val());
            });
            var status = $(this).val();

            if(expenses.length == 0 || expenses == null){                 
                alert('Selecione os rembolsos que serão atualizados');
                location.reload();
                return false;
            }

            swal("Deseja realmente alterar o status da despesa?", {
                buttons: {
                    cancel: "Cancelar",
                    OK: true,
                },
            }).then((value) => {
                switch (value) {
                    case "OK":
                        $.ajax({
                            headers: {
                                'X-CSRF-Token': $('input[name="_token"]').val()
                            },
                            type: "POST",
                            url: '{{route("expense.bulk_status")}}',
                            data: {
                                expenses: expenses,
                                status: status,
                            },
                            success: function (data) {
                                swal({
                                    title: "Bom trabalho!", text: data.mensagem, type: "success"
                                }).then(() => {
                                    location.reload();
                                });
                            },
                            error: function () {
                                swal("Ocorreu um erro inesperado durante o processamento!\n Recarrege a página e tente novamente.");
                            }
                        })
                        break;

                    default:
                        $(this).val('');
                        break;
                }
            });

        });
    </script>
@endsection
