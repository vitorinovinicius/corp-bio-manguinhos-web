@extends('layouts.frest_template_client')
@section('title','- Serviços / Exibir #'.$occurrence->id)
@php
    $move = $occurrence->moves()->where('move_type_id',4)->first();
    if($occurrence->operator){
        $track = $occurrence->operator->trakings->last();
    }else{
        $track = null;
    }
@endphp
@section('css')
    <!-- DataTables -->
    <link rel="stylesheet" href="/js/datatables/dataTables.bootstrap.css">

    <!-- leaflet -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
          integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
          crossorigin=""/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css"/>

@endsection
@section('content')

    @include("occurrences.includes.client.localizacao")
    <style nonce="{{ csp_nonce() }}">
        #map {
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 222px;
            position: relative;
        }
        .hidden-sms{
            display: none
        }
    </style>
@endsection

@section('scripts2')

    <!-- DataTables -->
    <script src="/js/datatables/jquery.dataTables.min.js"></script>
    <script src="/js/datatables/dataTables.bootstrap.min.js"></script>
    <script nonce="{{ csp_nonce() }}">
        $(function(){
            $('.hidden-sms').remove();
        })
        $(function () {
            $('.data-table').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": true,
            });
        });
    </script>
    @if(!empty($move->check_in_lat) AND !empty($move->check_in_long))


        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <!-- Leaflet Routing Machine -->
        <script src="/leaflet-routing-machine/dist/leaflet-routing-machine.min.js"></script>

        <script nonce="{{ csp_nonce() }}">
            setTimeout(function () {
                location.reload();
            }, 1 * 60 * 1500);


            // Rotinas do mapa
            @if($track)
                let initialCoordinates = [{!! $track->latitude !!}, {!! $track->longitude !!}]; // Rio de Janeiro
            @else
                let initialCoordinates = [-22.865523, -43.368974]; // Rio de Janeiro
            @endif
            let initialZoomLevel = 10;
            let markersData = [];

            // define o mapa
            let leafletMap = L.map('map', {scrollWheelZoom: false}).setView(initialCoordinates, initialZoomLevel);

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

                //Endereço de saída do técnico
                waypts.push({
                    lat: "{{$move->check_in_lat}}",
                    lng: "{{$move->check_in_long}}"
                });

                //Localização atual do técnico
                @if($track)
                waypts.push({
                    lat: "{!! $track->latitude !!}",
                    lng: "{!! $track->longitude !!}"
                });
                @endif

                //Endereço de chegada (cliente)
                waypts.push({
                    lat: "{{$traking["client_lat"]}}",
                    lng: "{{$traking["client_lng"]}}"
                });

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
                    showAlternatives: true,
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
                        } else if (i === 1) {
                            //This is the last marker indicating destination
                            popupText = "Coolaborador";
                        }  else if (i === (n - 1)) {
                            //This is the last marker indicating destination
                            popupText = "Destino (Cliente)";
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

            // icon: '/img/technical3.png',

        </script>

    @endif
    <!-- Select2 -->
@endsection
