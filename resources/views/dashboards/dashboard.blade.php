@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Relatório diversos</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Relatório diversos</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('content')
    @include('error')
    @include('helpers/filter_occurrences_dashboard')

    <div class="row" id="aguardeMessage">
        <div class="col-md-12">
            <div class="alert alert-success">
                <strong>Aguarde:</strong> estamos carregando os dados...
            </div>
        </div>
    </div>
    <div style="display: none" id="allBox">
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Total</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="chart-container" style="position: relative;">
                                <canvas id="totalChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Performance</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="performanceChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Não Realizadas</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="chart-container" style="position: relative;">
                                <canvas id="naoRealizadaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Os Fechadas</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="chart-container" style="position: relative;">
                                <canvas id="osFechadasChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="box-title">Os Pendentes - Total ({{$aGraficos['totalGeral']}})</h3>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <div class="chart-container">
                                <canvas id="chartPendente" style="width: 75%"></canvas>
                                <div id="chartPendenteText" style="font-size: 41px;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Técnicos ({{$operators->count()}})</h4>
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
                    @if($operators->count())
                        <div class="table-responsive">
                            <table id="table1" class="table table-sm table-striped table-hover table-condensed">
                                <thead>
                                <tr>
                                    <th class="text-left">Nome</th>
                                    <th class="text-center">Equipe</th>
                                    <th class="text-center">Supervisor</th>
                                    <th class="text-center">Região</th>
                                    <th class="text-center">Empreiteira</th>
                                    <th class="text-center">Total OS</th>
                                    <th class="text-center">Realizadas</th>
                                    <th class="text-center">Ñ realizadas</th>
                                    <th class="text-center">Média</th>
                                    <th class="text-center">Eficiência</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($operators as $operator)
                                    @php $result = dashboard_operator($operator)@endphp
                                    <tr>
                                        <td class="text-left">
                                            <a href="{{ route('operators.show', $operator->uuid) }}" class="btn-link">{{$operator->name}}</a>
                                        </td>
                                        <td class="text-center">{{$operator->teams[0]->name}}</td>
                                        <td class="text-center">{{$operator->teams[0]->users()->wherePivot('is_supervisor',1)->first()->name}}</td>
                                        <td class="text-center">{{$operator->regions->implode('name',', ')}}</td>
                                        <td class="text-center">{{(!empty($operator->contractor_id)? $operator->contractor->name : "-")}}</td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td>
                                        <td class="text-center"></td></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div><!--CARD-->


    </div><!--AllBOX-->    
@endsection

@section('scripts')

    <!-- DataTables -->
@section('vendor-scripts')
    <script src="{{asset('vendors/js/tables/datatable/datatables.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.bootstrap4.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.html5.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.print.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/buttons.bootstrap.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/pdfmake.min.js')}}"></script>
    <script src="{{asset('vendors/js/tables/datatable/vfs_fonts.js')}}"></script>
@endsection
{{-- page scripts --}}
@section('page-scripts')
    <script src="{{asset('js/scripts/datatables/datatable.js')}}"></script>
@endsection
{{--<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>--}}

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
<script type="text/javascript" src="https://bernii.github.io/gauge.js/dist/gauge.min.js"></script>
<script nonce="{{ csp_nonce() }}">

    var performanceChart = document.getElementById("performanceChart");
    var totalChart = document.getElementById("totalChart");
    var osFechadasChart = document.getElementById("osFechadasChart");
    var naoRealizadaChart = document.getElementById("naoRealizadaChart");
    var chartPendente = document.getElementById("chartPendente");
    var chartPendenteText = document.getElementById("chartPendenteText");

        {!! $aGraficos['aReferenceNRealizado'] !!}

    var myChart1 = new Chart(performanceChart, {
            type: 'horizontalBar',
            data: {
                labels: [{!! $aGraficos['aLabelPerformance'] !!}],
                datasets: [{
                    data: [{!! $aGraficos['aValuePerformance'] !!}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            fontSize: 16
                        }
                    }]
                }
            }
        });
    var myChart2 = new Chart(totalChart, {
        type: 'horizontalBar',
        data: {
            labels: [{!! $aGraficos['aLabelTotal'] !!}],
            datasets: [{
                data: [{!! $aGraficos['aValueTotal'] !!}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }],
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        fontSize: 16
                    }
                }],

            }
        }
    });
    var myChart4 = new Chart(osFechadasChart, {
        type: 'pie',
        data: {

            datasets: [
                {
                    data: [{!! $aGraficos['aValueFechadas'] !!}],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,

                }

            ],

            // These labels appear in the legend and in the tooltips when hovering different arcs
            labels: [
                {!! $aGraficos['aLabelFechadas'] !!}
            ]
        },
        options: {
            legend: {
                display: true,
                fontSize: 16
            }
        }
    });
    var myChart5 = new Chart(naoRealizadaChart, {
        type: 'horizontalBar',
        data: {
            labels: [{!! $aGraficos['aLabelNRealizado'] !!}],
            datasets: [{
                data: [{!! $aGraficos['aValueNRealizado'] !!}],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255,99,132,1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            legend: {
                display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true,
                        min: 0,
                        fontSize: 16
                    }
                }],
                xAxes: [{
                    ticks: {
                        fontSize: 14
                    }
                }]
            },
            // events: ['click'],
            // onClick: function (evt, elements) {
            //     var datasetIndex;
            //     var dataset;
            //
            //     if (elements.length) {
            //         var index = elements[0]._index;
            //
            //         var r = confirm("Deseja ir para este ítem?");
            //         if (r == true) {
            //             window.location = '/admin/occurrences/closed_unsolved?motivo_id=' + aReferenceNRealizado[index];
            //         }
            //
            //     }
            //
            // }
        }
    });

    // alert(aReferenceNRealizado);

    var opts = {
        angle: 0.15, // The span of the gauge arc
        lineWidth: 0.44, // The line thickness
        radiusScale: 1, // Relative radius
        pointer: {
            length: 0.6, // // Relative to gauge radius
            strokeWidth: 0.035, // The thickness
            color: '#000000' // Fill color
        },
        limitMax: false,     // If false, max value increases automatically if value > maxValue
        limitMin: false,     // If true, the min value of the gauge will be fixed
        colorStart: '#6FADCF',   // Colors
        colorStop: '#8FC0DA',    // just experiment with them
        strokeColor: '#E0E0E0',  // to see which ones work best for you
        generateGradient: true,
        highDpiSupport: true,     // High resolution support

    };

    //Reload da página
    var reload;
    reload = setTimeout(function () {
        // location.reload();
    }, 5 * 60 * 1000);

    $(document).on("change", "#update", function () {
        clearTimeout(reload);
    });

    //Reload da página - fim
    $(function () {
        $('#table1').DataTable({
            "paging": false,
            "lengthChange": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "autoWidth": true,
            "order": [[8, "desc"], [5, "desc"]],
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
            },

        });

        $("#allBox").show();

        var gauge = new Gauge(chartPendente).setOptions(opts); // create sexy gauge!
        gauge.maxValue = {{$aGraficos['totalGeral']}}; // set max gauge value
        gauge.setMinValue(0);  // Prefer setter over gauge.minValue = 0
        gauge.setTextField(chartPendenteText);
        gauge.animationSpeed = 32; // set animation speed (32 is default value)
        gauge.set({{$aGraficos['totalPendente']}}); // set actual value

        $("#aguardeMessage").hide();

    });

</script>

@endsection
