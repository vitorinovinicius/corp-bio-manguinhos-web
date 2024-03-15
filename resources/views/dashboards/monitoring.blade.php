@extends('layouts.frest_template')
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">
    @if(env('TIPO_MAPA') == 'LEAFLETJS')
       <!-- Leaflet Map -->
    <link rel="stylesheet" href="/leaflet/dist/leaflet.css">
    <!-- Leaflet Routing Machine -->
    <link rel="stylesheet" href="/leaflet-routing-machine/dist/leaflet-routing-machine.css">
    <!-- Leaflet Fullscreen plugin -->
    <link rel="stylesheet" href="/leaflet-fullscreen-1.6.0/Control.FullScreen.css">
    <!-- Leaflet Geocoding plugin -->
    <link rel="stylesheet" href="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.css"
          integrity="sha512-IM3Hs+feyi40yZhDH6kV8vQMg4Fh20s9OzInIIAc4nx7aMYMfo+IenRUekoYsHZqGkREUgx0VvlEsgm7nCDW9g=="
          crossorigin="">
    @endif
@endsection

@section('content-header')
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Monitoramento</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Dashboard</li>
                        <li class="breadcrumb-item active">Monitoramento</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('content')
    @include('error')
    @include('helpers/filter_occurrences_dashboard')
    <style nonce="{{ csp_nonce() }}">
        #map {
            height: 50vh;
        }
    </style>

    @include('dashboards.contadores')

    <div class="card">
        <div class="card-header">
            <h4 class="card-title">Mapa de Operação</h4>
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
                <div class="row">
                    <div class="col-12">
                        <div class="marker-filter">
                                <span class="filter-box">
                                    <label for="regular">
                                        <input type="checkbox" class="cs_checkbox" name="have_occurrence" id="have_occurrence" onchange="filterMarker();">
                                        Só com Ocorrências
                                    </label>
                                </span>
                        </div>
                    </div>
                </div>

                <div id="weathermap">
                    <div id="map"></div>
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
{{--                                <th class="text-center">Supervisor</th>--}}
{{--                                <th class="text-center">Empreiteira</th>--}}
                                <th class="text-center">Total OS</th>
                                <th class="text-center">Realizadas</th>
                                <th class="text-center">Ñ realizadas</th>
                                <th class="text-center">Eficiência</th>
                                <th class="text-center">Jornada</th>
                                <th class="text-center">Alertas</th>
                            </tr>
                            </thead>

                            <tbody class="include_technical">
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection
@section('scripts')

    @if(env('TIPO_MAPA') == 'GOOGLE')
        <script type="text/javascript" src="/js/maps.js"></script>
        <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&callback=initMap"></script>
    @elseif(env('TIPO_MAPA') == 'LEAFLETJS')
        <!-- Leaflet Map -->
        <script src="/leaflet/dist/leaflet.js"></script>
        <!-- Leaflet Routing Machine -->
        <script src="/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>
        <!-- Leaflet Fullscreen plugin -->
        <script src="/leaflet-fullscreen-1.6.0/Control.FullScreen.js"></script>

        <!-- Load Esri Leaflet from CDN -->
        <script src="https://unpkg.com/esri-leaflet@2.5.0/dist/esri-leaflet.js" nonce="r@nd0m"
            integrity="sha512-ucw7Grpc+iEQZa711gcjgMBnmd9qju1CICsRaryvX7HJklK0pGl/prxKvtHwpgm5ZHdvAil7YPxI1oWPOWK3UQ=="
            crossorigin=""></script>

         <!-- Leaflet Geocoding plugin -->
        <script src="https://unpkg.com/esri-leaflet-geocoder@2.3.3/dist/esri-leaflet-geocoder.js"
            integrity="sha512-HrFUyCEtIpxZloTgEKKMq4RFYhxjJkCiF5sDxuAokklOeZ68U2NPfh4MFtyIVWlsKtVbK5GD2/JzFyAfvT5ejA=="
            crossorigin=""></script>

        <script type="text/javascript" src="/js/mapsFlet.js"></script>
        <script>
            initMap();
        </script>

    @endif

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

    <script nonce="{{ csp_nonce() }}">

        $(function () {
            var table = $('#table1').DataTable({
                "paging": false,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
                "ajax": '{!! route('admin.dashboard.list',request()->all()) !!}',
                "dataSrc": "",
                "order": [[6, "desc"], [2, "desc"],[3, "desc"]],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
                },
                "columns": [
                    {data: "nome"},
                    {data: "equipe"},
                    // {data: "supervisor"},
                    // {data: "empreiteira"},
                    {data: "total_os"},
                    {data: "total_realizadas"},
                    {data: "total_nao_realizadas"},
                    {
                        data: "eficiencia",
                        createdCell: function (td, cellData, rowData) {
                            $(td).addClass(rowData["cor_eficiencia"])
                        }
                    },
                    {
                        data: "media",
                        createdCell: function (td, cellData, rowData) {
                            $(td).addClass(rowData["cor_media"])
                        }
                    },
                    {data: "alertas"},
                ],
                // createdRow: function (row, data) {
                //     $(row).addClass(data["cor_eficiencia"])
                // }
            });


            function technical_maps() {
                $.ajax({
                    type: 'GET',
                    url: '{!! route('admin.dashboard.technical_maps',request()->all()) !!}',
                    success: function (data) {
                        deleteMarkers();
                        addMarkers(data);
                        showMarkers();
                        filterMarker();
                    },
                    error: function () {
                        console.log("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                    }
                });
            }

            @if(env('TIPO_MAPA') == 'GOOGLE')

                function os_maps() {
                    $.ajax({
                        type: 'GET',
                        url: '{!! route('admin.dashboard.os_maps',request()->all()) !!}',
                        success: function (data) {
                            // deleteMarkersOS();
                            addMarkersOS(data);
                            // showMarkers();
                        },
                        error: function () {
                            console.log("Ocorreu um erro inesperado durante o processamento.\nRecarregue a página e tente novamente");
                        }
                    });
                }

                os_maps();

            @endif


            technical_maps();

            @if(env('TIPO_MAPA') == 'GOOGLE')

                setInterval(function () {
                    table.ajax.reload();
                    os_maps();
                    technical_maps();
                }, 1 * 60 * 1000);

            @else

                setInterval(function () {
                    table.ajax.reload();
                    technical_maps();
                }, 1 * 60 * 1000);

            @endif

        });
    </script>
@endsection
