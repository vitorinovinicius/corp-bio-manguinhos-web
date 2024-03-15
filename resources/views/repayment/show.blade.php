@extends('layouts.frest_template')
@section('css')
    <link rel="stylesheet" href="{{asset('/bower_components/AdminLTE/plugins/select2/select2.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/daterange/daterangepicker.css')}}">
@endsection

@section('content-header')
    <div class="content-header-left col-10 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Reembolso</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item active">Reembolso</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="col-2 d-flex justify-content-end align-items-center">
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
                </div>
                <div class="card-content {{app('request')->exists('name') == false ? "" : "show" }}">
                    <div class="card-body">
                        <form class="form form-vertical form_export" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    @is('superuser')
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Empreiteira</label>
                                            <select class="form-control select2" name="contractor_id" id="contractor" data-placeholder="Selecione uma empreiteira">
                                                <option></option>
                                                @forelse(\App\Models\Contractor::all() as $contractor)
                                                    <option value="{{$contractor->id}}" {{(app('request')->input('contractor_id')==$contractor->id?"selected":"")}}>{{$contractor->name}}</option>
                                                @empty
                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                    @endis
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Técnico</label>
                                            <select class="form-control select2" name="user_id" id="user_id" data-placeholder="Técnico">
                                                <option></option>
                                                @if($operators)
                                                    @foreach ($operators as $operator)
                                                        <option value="{{$operator->id}}" {{(app('request')->input('user_id')==$operator->id?"selected":"")}}>{{$operator->name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            {{-- <input class="form-control" type="text" name="name" placeholder="" value="{{ app('request')->input('name') }}"> --}}
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="form-group">
                                            <label>Período</label>
                                            <input type="text" class="form-control daterange" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
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
    @if($expenses->count())
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 mt-1 mb-2 d-flex justify-content-between">
                            <div>
                                <h4>Resumo</h4>
                            </div>
                            <div>
                                <a class="btn btn-primary" href="{{ route('repayment.pdf', ["contract"=>$contractor_id, "operator"=>$user_id, "dateIn"=>$dateIn, "dateFn"=>$dateFn]) }}" target="_blank"><i class='bx bxs-file-pdf'></i> Exportação completa</a>
                            </div>

                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div id="resume" class="col-md-6">
                            <h5>Valores</h5>
                            <ul>
                                <li>
                                    <b>Total:</b> R$ {{number_format((float)($valueTotal), 2, ',', '')}}
                                </li>
                                <li>
                                    <b>Pagas:</b> R$ {{number_format((float)($paidOutValueTotal), 2, ',', '')}}
                                </li>
                                <li>
                                    <b>Pendentes:</b> R$ {{number_format((float)($pendingValueTotal), 2, ',', '')}}
                                </li>
                                <li>
                                    <b>Recusadas:</b> R$ {{number_format((float)($refusedValueTotal), 2, ',', '')}}
                                </li>
                                <li>
                                    <b>Inválidas:</b> R$ {{number_format((float)($inactiveValueTotal), 2, ',', '')}}
                                </li>
                            </ul>
                        </div>
                        <div class="">
                            <h5>Despesas</h5>
                            <div id="chart-total" class="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between">
                        <div>
                            <b>Peíodo:</b> {{$dateIn}} à {{$dateFn}}
                        </div>
                        <div>
                            <a href="{{ route('export.repayment', ["contract"=>$contractor_id, "operator"=>$user_id, "dateIn"=>$dateIn, "dateFn"=>$dateFn])}}" class="btn btn-success" id="export"><i class="bx bx-download"></i> Exportar</a>
                        </div>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row">

                                {{-- Daddos das dispesas do tipo KM --}}
                                {{-- <div class="col-12">
                                    <div class="card" style="border: 1px solid #dfe3e7">
                                        <div class="card-header" style="border-bottom: 1px solid #dfe3e7; padding: 10px">
                                            KM
                                        </div>
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div> --}}

                                {{-- Daddos das dispesas do tipo avulso --}}

                                @if(count($aExpenses) > 0)
                                    @foreach($aExpenses as $expenses)
                                        <div class="col-12">
                                            <div class="card" style="border: 1px solid #dfe3e7">
                                                <div class="card-header" style="border-bottom: 1px solid #dfe3e7; padding: 10px">
                                                    <h6>{{$expenses['expenses'][0]->dateFormat()}} - R$ {{number_format((float)($expenses['total']), 2, ',', '')}}</h6>
                                                </div>
                                                <div class="">
                                                    @if(count($expenses))
                                                        <div class="table-responsive">
                                                            <table class="table table-condensed table-striped table-sm">
                                                                <thead>
                                                                <tr>
                                                                    <th>Operador</th>
                                                                    <th>OS</th>
                                                                    <th>Despesa</th>
                                                                    <th>Valor</th>
                                                                    <th>Data</th>
                                                                    <th>Comprovante</th>
                                                                    <th>Status</th>
                                                                    <th>Motivo</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($expenses['expenses'] as $expense)
                                                                    <tr>
                                                                        <td>{{optional($expense->user)->name}}</td>
                                                                        <td>{{optional($expense->occurrence)->id}}</td>
                                                                        <td>{{optional($expense->expenseTypes)->name}}</td>
                                                                        <td>{{number_format((float)$expense->value, 2, ',', '.')}}</td>
                                                                        <td>{{$expense->dateFormat()}}</td>
                                                                        <td>
                                                                            @if($expense->archives->count())
                                                                                @foreach ($expense->archives as $fotos)
                                                                                    <button class="btn btn-primary open-modal-img" data-toggle="modal" data-target="#imgModal" data-image="{{$fotos->url}}"><i class="bx bxs-camera"></i></button>
                                                                                @endforeach
                                                                            @endif
                                                                        </td>
                                                                        <td>
                                                                        <span
                                                                            class="badge badge-large {{ $expense->status_label() }}">
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
                                                                        <td>{{$expense->cancellation_reason}}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-white">
                    <h3>Não foram encontradas reembolso no período escolhido.</h3>

                </div>
            </div>
        </div>
    @endif
@endsection

<div class="modal fade" id="imgModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" title="Fechar">
                    <span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Imagem ampliada</h4>
            </div>
            <div class="modal-body">
                <div><img class="img-thumbnail max-75vh" id="recebe-image"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <!-- Select2 -->
    <script src="{{asset('/bower_components/AdminLTE/plugins/select2/select2.full.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/daterangepicker.js')}}"></script>
    <script src="{{asset('vendors/js/charts/apexcharts.min.js')}}"></script>
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


        $('#contractor').change(function () {
            var id = $(this).val();

            $.ajax({
                type: "GET",
                url: '/admin/operators/ajax/' + id,
                success: function (data) {
                    // console.log(data);
                    var option = '';
                    option += '<option></option>';
                    $.each(data, function (i, obj) {
                        option += '<option value="' + obj.id + '">' + obj.name + '</option>';
                    });
                    $('#user_id').html(option).show();
                    // console.log(option);
                },
                error: function () {
                    console.log('merge')
                }
            })
        });


        var options = {
            plotOptions: {
                pie: {
                    size: 80
                }
            },
            chart: {
                type: 'donut'
            },
            series: [{{$paidOut}}, {{ $pending}}, {{$refused}}, {{$inactive}}],
            labels: ['Pago', 'Pendente', 'Recusado', 'Invalidado']
        }

        var chart = new ApexCharts(document.querySelector("#chart-total"), options);

        chart.render();

        $(document).on("click", ".open-modal-img", function () {
            let image = $(this).data("image");
            // console.log(image);
            $("#recebe-image").attr("src", image);
        });

    </script>
@endsection
