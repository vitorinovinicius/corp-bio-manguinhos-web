@extends('layouts.adminlte')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.css" />

@endsection
@section('header')
    <h1>
        Quantitativo de OS
        <small>Central System</small>
    </h1>
    <ol class="breadcrumb">
        <li><i class="bx bx-dashboard"></i> Home</li>
        <li>OS</li>
    </ol>

@endsection

@section('content')
    @include('error')
    @is(['regiao','superuser','admin'])

    <section class="content">
        <!-- Select2 -->
        <link rel="stylesheet" href="/bower_components/AdminLTE/plugins/select2/select2.min.css">
        <div  class="box box-default clearfix {{ app('request')->exists('contractor_id') == false ? "collapsed-box" : ""}}">
            <div class="box-header with-border" >
                <h3 class="box-title">Filtro</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="bx bx-plus"></i></button>
                </div>
            </div>
            <div class="box-body"  >
                <div class="row">
                    <form method="get">
                        <div class="col-md-12">



                            <div class="form-group col-md-2">
                                <div>Período</div>
                                <input type="text" class="input-small daterange" size="25" id="scheduled_date" name="scheduled_date" value="{{ app('request')->input('scheduled_date') }}" readonly>
                            </div>
                            <div class="form-group col-md-2">
                                <br>
                                <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                <a href="/{{Route::getCurrentRoute()->uri()}}" class="btn btn-default">Limpar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-12">
                <div class="box box-solid box-danger">
                    <div class="box-header">
                        <h3 class="box-title">Monitoramento de OS - {{$scheduled_date}}</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="bx bx-minus"></i></button>
                        </div>
                    </div>
                    <div class="box-body padding-bottom-0">
                        <div class="col-md-12 padding-0">
                            <div id="chart_div"></div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </section>

    @endis
@endsection
@section('scripts')

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="/js/maps.js"></script>
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/daterangepicker/moment.min.js"></script>
    <script type="text/javascript" src="/bower_components/AdminLTE/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Select2 -->
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/datatables/dataTables.bootstrap.min.js"></script>
    <script nonce="{{ csp_nonce() }}">

        $(function () {

            google.charts.load('current', {packages: ['corechart', 'bar']});
            google.charts.setOnLoadCallback(drawMultSeries);

            function drawMultSeries() {
                var data = google.visualization.arrayToDataTable([
                    ['', 'Realizadas', 'Não Realizadas'],
                    {!! $jsonCompare !!}
                ]);

                var options = {
                    title: 'OS executadas',
                    chartArea: {width: '50%'},
                    hAxis: {
                        title: 'Total OS',
                        minValue: 0
                    },
                    vAxis: {
                        title: ''
                    }
                };

                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }


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

            $('.daterange').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
            });
            $('.daterange').on('cancel.daterangepicker', function(ev, picker) {
                $(this).val('');
            });
        });
    </script>
@endsection
