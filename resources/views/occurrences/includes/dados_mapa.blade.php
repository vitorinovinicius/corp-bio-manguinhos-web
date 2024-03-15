@if($occurrence->status == 2 || $occurrence->status == 3)
    <div class="row">
        <div class="col-6">
            <div class="form-group">
                <label>CheckIn</label>
                <p class="form-control-static" >{{(!empty($occurrence->check_in)) ? date('d/m/Y H:i:s', strtotime($occurrence->check_in)) : "Não foi capturado o CheckIn"}}</p>
            </div>
            @if(!empty($occurrence->check_in_lat) AND !empty($occurrence->check_in_long))
                <div class="form-group">
                    <label></label>
                    <p class="" ><a href="https://www.google.com/maps/?q={{$occurrence->check_in_lat}},{{$occurrence->check_in_long}}" class="btn btn-info btn-sm" target="_blank"><i class="bx bx-share"></i>Ver no Maps</a></p>
                </div>
            @endif
        </div>
        <div class="col-6">
            <div class="form-group">
                <label>CheckOut</label>
                <p class="form-control-static" >{{(!empty($occurrence->check_out)) ? date('d/m/Y H:i:s', strtotime($occurrence->check_out)) : "Não foi capturado o CheckOut"}}</p>
            </div>
            @if(!empty($occurrence->check_out_lat) AND !empty($occurrence->check_out_long))
                <div class="form-group">
                    <label></label>
                    <p class="" ><a href="https://www.google.com/maps/?q={{$occurrence->check_out_lat}},{{$occurrence->check_out_long}}" class="btn btn-info btn-sm" target="_blank"><i class="bx bx-share"></i>Ver no Maps</a></p>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        @if(!empty($occurrence->check_in_lat) && !empty($occurrence->check_in_long) && !empty($occurrence->check_out_lat) && !empty($occurrence->check_out_long) && Request::input("maps") != 'false')
            <div class="col-12">
                <div class="form-group">
                    <div id="map" style="width: 100%;"></div>
                </div>
            </div>
        @else
            <div class="col-12">
                <div class="form-group">
                    Não foi possível definir a localização.
                </div>
            </div>
        @endif
    </div>
@endif

@if(!empty($occurrence->check_in_lat) && !empty($occurrence->check_in_long) && !empty($occurrence->check_out_lat) && !empty($occurrence->check_out_long) && Request::input("maps") != 'false')
    <style>
        #map {
            height: 0;
            overflow: hidden;
            padding-bottom: 22.25%;
            padding-top: 80px;
            position: relative;
        }
    </style>

    @if(env('TIPO_MAPA') == 'GOOGLE')
        <script type="text/javascript" src="/js/maps.js"></script>
        <script async defer
                src="https://maps.googleapis.com/maps/api/js?key={{env('GOOGLE_MAPS_KEY')}}&callback=initMap">
        </script>
    @elseif(env('TIPO_MAPA') == 'LEAFLETJS')
        <!-- Make sure you put this AFTER Leaflet's CSS -->
        <script src="https://unpkg.com/leaflet@1.6.0/dist/leaflet.js"
                integrity="sha512-gZwIG9x3wUXg2hdXF6+rVkLF/0Vi9U8D2Ntg4Ga5I5BZpVkVxlJWbSQtXPSiUTtC0TjtGOmxa1AJPuV0CPthew=="
                crossorigin=""></script>
        <script src="https://unpkg.com/leaflet.icon.glyph@0.2.0/Leaflet.Icon.Glyph.js"></script>
        <script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>
        {{--        <script src="https://api.mapbox.com/mapbox-gl-js/v1.10.0/mapbox-gl.js"></script>--}}
        {{--        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-geocoder/v4.5.1/mapbox-gl-geocoder.min.js"></script>--}}
        {{--        <script src="https://api.mapbox.com/mapbox-gl-js/plugins/mapbox-gl-directions/v4.0.2/mapbox-gl-directions.js"></script>--}}
    @endif

    <script nonce="{{ csp_nonce() }}">
        @if(env('TIPO_MAPA') == 'GOOGLE')
        function initMap() {
            var directionsService = new google.maps.DirectionsService;
            var directionsDisplay = new google.maps.DirectionsRenderer;
            var map = new google.maps.Map(document.getElementById('map'), {
                zoom: 7,
                center: {lat: '{!! $occurrence->check_in_lat !!}', lng: '{!! $occurrence->check_in_long !!}'}
            });
            directionsDisplay.setMap(map);

            calculateAndDisplayRoute(directionsService, directionsDisplay);
        }

        function calculateAndDisplayRoute(directionsService, directionsDisplay) {
            directionsService.route({
                origin: "{{optional($occurrence->occurrence_client)->address}} {{optional($occurrence->occurrence_client)->number}} {{optional($occurrence->occurrence_client)->city}}",
                destination: "{!! $occurrence->check_out_lat !!},  {!! $occurrence->check_out_long !!}",
                travelMode: 'WALKING'
            }, function (response, status) {
                if (status === 'OK') {
                    directionsDisplay.setDirections(response);
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            });
        }
        @else

            mapLet = L.map('map', {
            center:[{!! $occurrence->check_in_lat !!}, {!! $occurrence->check_in_long !!}],
            zoom: 17,
            zoomControl: true,
            scrollWheelZoom:false,
            dragging: false,
        });
        //mapLet = L.map('map').setView([-22.998207374475896, -43.354480527341366], 13);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.centralsystem.com.br">CentralSystem</a> contributors'
        }).addTo(mapLet);

        L.Routing.control({

            waypoints: [
                L.latLng({!! $occurrence->check_in_lat !!}, {!! $occurrence->check_in_long !!}),
                L.latLng({!! $occurrence->check_out_lat !!}, {!! $occurrence->check_out_long !!})
            ],
            show: false,
            draggable: true,
            routeWhileDragging: false,
            createMarker: function(i, wp) {
                return L.marker(wp.latLng, {
                    draggable: false,
                    icon: L.icon.glyph({ glyph: String.fromCharCode(65 + i) })
                });
            },
        }).addTo(mapLet);


        {{--var token =  mapboxgl.accessToken = 'pk.eyJ1IjoiY2VudHJhbHN5c3RlbSIsImEiOiJjazl0eHpyaGgxbDV1M3FwanhqOTluamNyIn0.wPudylkCQ3V-u9BUzayQ1A';--}}

        {{-- var map = new mapboxgl.Map({--}}
        {{--     container: 'map',--}}
        {{--     style: 'mapbox://styles/mapbox/streets-v11',--}}
        {{--     center: [-43.354480527341366, -22.998207374475896],--}}
        {{--     zoom: 9--}}
        {{-- });--}}


        {{-- var directions = new MapboxDirections({--}}
        {{--     accessToken: token,--}}
        {{--     unit: 'metric',--}}
        {{--     profile: 'mapbox/cycling'--}}
        {{--     })--}}
        {{--     .setOrigin("{query:'{{optional($occurrence->occurrence_client)->address}} {{optional($occurrence->occurrence_client)->number}} {{optional($occurrence->occurrence_client)->city}}'}")--}}
        {{--     .setDestination([{!! $occurrence->check_out_long !!}, {!! $occurrence->check_out_lat !!}]);--}}

        {{-- map.addControl(--}}
        {{--     directions--}}
        {{-- );--}}
        {{-- $('.mapboxgl-canvas').trigger('click');--}}
        @endif
    </script>

@endif
