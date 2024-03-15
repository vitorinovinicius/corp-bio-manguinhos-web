@extends('layouts.frest_template')
@section('css')

    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/pickers/pickadate/pickadate.css')}}">

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css"/>

    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">

@endsection
{{-- vendor styles --}}
@section('vendor-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('vendors/css/extensions/toastr.css')}}">
@endsection

{{-- page styles --}}
@section('page-styles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/plugins/extensions/toastr.css')}}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <style nonce="{{ csp_nonce() }}">
        #mapRoteiro {
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 222px;
            position: relative;
        }
    </style>
@endsection

@section('content-header')
    <div class="content-header-left col-9 mb-2 mt-1">
        <div class="row breadcrumbs-top">
            <div class="col-12">
                <h5 class="content-header-title float-left pr-1 mb-0">Rastreamento do técnicos / Exibir #{{$operator->name}}</h5>
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb p-0 mb-0">
                        <li class="breadcrumb-item"><i class="bx bx-home-alt"></i> Home</li>
                        <li class="breadcrumb-item">Rastreamento do técnicos</li>
                        <li class="breadcrumb-item active">Exibir</li>
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
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Filtro</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-vertical" method="GET">
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Data</label>
                                            <input type="text" autocomplete="off" class="form-control date-picker" id="schedule_date" name="schedule_date" value="{{ app('request')->input('schedule_date') }}" placeholder="Data do agendamento" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label>Hora</label>
                                            <input type="time" autocomplete="off" class="form-control" id="schedule_time" name="schedule_time" value="{{ app('request')->input('schedule_time') }}" placeholder="Hora do agendamento" required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group">
                                            <br>
                                            <button type="submit" class="btn btn-primary " id="btn-external-filter">Aplicar</button>
                                            <a href="{{route('operator.tracking',$operator->uuid)}}" class="btn btn-default">Limpar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Rastreamento</h3>
                </div>
                <div class="card-body">
                    <div class="col-md-12">
                        <span class="font-medium-3">
                            Rastreamento do técnico limitado ao intervalo de 1h a partir da Data e Hora escolhodos.
                            Caso não tenha escolhido nenhuma data, iremos mostrar as últimas 30 capturas.</span>
                    </div>
                    <br>
                    <div id="mapRoteiro"></div>
                    <div id="mapError" style="display: none;">
                        <span class="text-danger"><i class="glyphicon glyphicon-exclamation-sign"></i> Falha ao montar mapa das entregas</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="box-title">Conectividade</h3>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-condensed table-striped table-sm dataTable">
                                <thead>
                                <tr>
                                    <th>Latitude</th>
                                    <th>Longitude</th>
                                    <th>Data/hora</th>
                                    <th>Mapa</th>
                                </tr>
                                </thead>

                                <tbody>
                                @foreach($trackings as $tracking)
                                    <tr>
                                        <td>{{$tracking->latitude}}</td>
                                        <td>{{ $tracking->longitude }}</td>
                                        <td>{{ dataTimeFormat($tracking->created_at) }}</td>
                                        <td>
                                            <a href="https://www.google.com/maps/?q={{$tracking->latitude}},{{$tracking->longitude}}"
                                               class="btn btn-info btn-xs" target="_blank"><i class="bx bx-share"></i>Ver no
                                                Maps</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <a class="btn btn-primary float-right" href="{{ route('operators.show', $operator->uuid) }}"><i class="bx bx-arrow-back"></i> Voltar</a>
        </div>

    </div>
@endsection

@section('scripts')

    <script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/daterange/moment.min.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.js"></script>

    <script src="{{asset('vendors/js/pickers/pickadate/picker.js')}}"></script>
    <script src="{{asset('vendors/js/pickers/pickadate/picker.date.js')}}"></script>
    <script src="{{ url('/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
            integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
            crossorigin=""></script>
    <!-- Leaflet Routing Machine -->
    <script src="/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>




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


    $('.dataTable').DataTable({
        "paging": true,
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Portuguese.json"
        }
    });

    $('.date-picker').pickadate({
        format: 'dd/mm/yyyy',
        formatSubmit: 'dd/mm/yyyy',
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


    // Rotinas do mapa
    let initialCoordinates = [-22.865523, -43.368974]; // Rio de Janeiro
    let initialZoomLevel = 13;
    let markersData = [];

    let checkinMap;
    let checkoutMap;


    // define o mapa
    let leafletMap = L.map('mapRoteiro', {scrollWheelZoom: false}).setView(initialCoordinates, initialZoomLevel);

    // tema do mapa. outros temas em: https://leaflet-extras.github.io/leaflet-providers/preview/
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 17,

    }).addTo(leafletMap);

    showRouteByTracking();

    // Cria rota percorrida pelo motorista com base no tracking
    function showRouteByTracking() {

        // define os waypoints
        waypts = [];
        @if(count($trackings) > 0)
        @foreach($trackings as $coord)
        waypts.push({
            lat: "{{$coord->latitude}}",
            lng: "{{$coord->longitude}}"
        });
        @endforeach
            @endif

        if (waypts.length === 0) {
            return;
        }

        // waypoints
        let aWaypoints = [];
        for (let i = 0; i < waypts.length; i++) {
            aWaypoints.push(L.latLng(waypts[i].lat, waypts[i].lng));
        }

        console.log(aWaypoints);


        // Renderiza a rota no mapa
        L.Routing.control({
            waypoints: aWaypoints,
            language: 'pt-BR',
            showAlternatives: false,
            lineOptions: {
                styles: [{
                    color: '#121416', opacity: 0.8, weight: 4
                }],
                addWaypoints: false, // desabilita criacao de novo waypoint
                linetouched: function () {
                    return false; // desabilita evento de clique nas linhas da rota
                }
            },
            createMarker: function (i, start, n) {

                let popupText = "";
                if (i === 0) {
                    // This is the first marker, indicating start
                    popupText = "Início";
                } else if (i === (n - 1)) {
                    //This is the last marker indicating destination
                    popupText = "Fim";
                } else {
                    return null;
                }

                return L.marker(start.latLng, {
                    title: popupText,
                    draggable: false,
                    bounceOnAdd: false,
                }).bindTooltip(popupText, {permanent: true, offset: [2, 10]});
            }
        }).addTo(leafletMap) // adiciona ao mapa
            .hide(); // minimiza as instrucoes do itinerario
    }

</script>
@endsection
