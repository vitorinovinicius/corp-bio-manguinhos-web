// Váriáveis necessárias
let markers = [];
let marker;
let mapLet;
let myIcon;
let locations;
let search;
let popup = L.popup({
    offset: [0, -30]
});
let markersLayer = new L.LayerGroup();

function initMap(){
    mapLet = L.map('map', {
        center:[-22.9195936, -43.2555133],
        zoom: 10.5,
        zoomControl: true,
        scrollWheelZoom:false,
    });

    //Modelo do mapa atual
    L.tileLayer('https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}{r}.png', {
        attribution: '© OpenStreetMap contributors',
        maxZoom: 17,
    }).addTo(mapLet);

    //Modelo map antigo
    // L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    //     attribution: '&copy; <a href="https://www.centralsystem.com.br">CentralSystem</a> contributors',

    // }).addTo(mapLet);

    var searchControl = L.esri.Geocoding.geosearch({
        position: 'topleft',
        placeholder: 'Pesquisar endereço',
        useMapBounds: false,
      }).addTo(mapLet);

    var results = L.layerGroup().addTo(mapLet);

    searchControl.on('results', function (data) {
        results.clearLayers();
        for (var i = data.results.length - 1; i >= 0; i--) {
        results.addLayer(L.marker(data.results[i].latlng));
        }
    });

    // listen for the results event and add every result to the map
    // searchControl.on("results", function (data) {
    //     results.clearLayers();
    // });



}



function markerOnClick(e, url) {

    popup.setLatLng(e.latlng)
        .setContent(url)
        .openOn(mapLet);
}

function addMarkers(markJson){

    locations = markJson;

    locations.map(function (location, i) {
        if ( location.icon){
            myIcon = L.icon({
                iconUrl: location.icon,
                iconSize: [38, 38],
                iconAnchor: [20, 40],
            });
        } else {
            myIcon = L.icon({
                iconUrl: '/js/leaflet/images/marker-icon.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            });
        }
        marker = L.marker(
            [location.lat, location.lng],
            {
                have_occurrence:location.have_occurrence,
                nome: location.nome,
                icon: myIcon

            })
            .on('click', function(e) {
                markerOnClick(e,location.nome)
            });
            markersLayer.addLayer(marker).addTo(mapLet);

        markers.push(marker);
    })
}

function addMarkersOS(address){

    address.map(function(location, i) {
        console.log(location.address);

        if ( location.icon){
            myIcon = L.icon({
                iconUrl: location.icon,
                iconSize: [38, 38],
                iconAnchor: [20, 40],
                className: 'teste'
            });
        } else {
            myIcon = L.icon({
                iconUrl: '/js/leaflet/images/marker-icon.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
            });
        }
        marker = L.marker(
            [location.lat, location.lng],
            {
                have_occurrence:location.have_occurrence,
                nome: location.nome,
                icon: myIcon

            })
            .on('click', function(e) {
                markerOnClick(e,location.nome)
            });
        markersLayer.addLayer(marker).addTo(mapLet);

        markers.push(marker);
    });
}

function deleteMarkers() {
    markers = [];
    markersLayer.clearLayers();

}

function showMarkers() {
}

filterMarker = function (){
    if ($("#have_occurrence").is(':checked')) {
        for (i = 0; i < markers.length; i++) {
            marker = markers[i];
            if (marker.options.have_occurrence === 1) {
                if (markersLayer.hasLayer(marker) == false) {
                    marker = L.marker(
                    [marker._latlng.lat, marker._latlng.lng],
                    {
                        have_occurrence: marker.options.have_occurrence,
                        nome: marker.options.nome,
                        icon: marker.options.icon
                    }).on('click', function (e) {
                        markerOnClick(e,marker.options.nome)
                    });
                    markersLayer.addLayer(marker).addTo(mapLet);
                }
            } else {
                if (markersLayer.hasLayer(marker) == true) {
                    markersLayer.removeLayer(marker);
                }
            }
        }
    } else {

        marker = '';
        locations.map(function (location, i) {
            if ( location.icon){
                myIcon = L.icon({
                    iconUrl: location.icon,
                    iconSize: [38, 38],
                    iconAnchor: [20, 40],
                    className: 'teste'
                });
            } else {
                myIcon = L.icon({
                    iconUrl: '/js/leaflet/images/marker-icon.png',
                    iconSize: [25, 41],
                    iconAnchor: [12, 41],
                });
            }
            marker = L.marker(
                [location.lat, location.lng],
                {
                    have_occurrence:location.have_occurrence,
                    nome: location.nome,
                    icon: myIcon,

                })
                .on('click', function(e) {
                    markerOnClick(e,location.nome)
                });
            markersLayer.addLayer(marker).addTo(mapLet);

            markers.push(marker);
        })
    }
}

