// Váriáveis necessárias
let map;
let image = '/css/images/worker_icon.png';
let markers = [];
// let marker;
let myIcon;

function initMap() {
    let haightAshbury = {lat: -22.865523, lng: -43.368974};
    geocoder = new google.maps.Geocoder();

    map = new google.maps.Map(document.getElementById('map'), {
        zoom: 10,
        center: haightAshbury,
        mapTypeId: 'roadmap',
        scrollwheel: false,
        mapTypeControl: false
    });

    // Adds a marker at the center of the map.
}

function addMarkers(markJson) {
    const infoWin = new google.maps.InfoWindow();

    markJson.map(function (location, i) {

        if ( location.icon){
            myIcon = location.icon;
        } else {
            myIcon = image;
        }

        const marker = new google.maps.Marker({
            position: location,
            map: map,
            icon: myIcon,
            title: location.title,
            have_occurrence: location.have_occurrence
        });
        google.maps.event.addListener(marker, 'click', function (evt) {
            infoWin.setContent(location.nome);
            infoWin.open(map, marker);
        });

        google.maps.event.addListener(map, 'click', function(){
            infoWin.close(map, marker);
        });
        // markers.push(marker);
    });
}

function addMarkersOS(markJson) {
    const infoWin = new google.maps.InfoWindow();

    markJson.map(function (location, i) {
        // console.log(location.address);

        geocoder.geocode({'address': location.address}, function (results, status) {

            if (status == 'OK') {
                const markerOS = new google.maps.Marker({
                    map: map,
                    title: location.nome,
                    position: results[0].geometry.location,
                    is_occurrence: true
                });

                google.maps.event.addListener(markerOS, 'click', function (evt) {
                    infoWin.setContent(location.nome);
                    infoWin.open(map, markerOS);
                });

                google.maps.event.addListener(map, 'click', function(){
                    infoWin.close(map, markerOS);
                });

                // markers.push(markerOS);

            }
        });
    });
}

filterMarker = function () {
    if ($("#have_occurrence").is(':checked')) {

        for (i = 0; i < markers.length; i++) {
            const marker = markers[i];
            if ($("#have_occurrence").is(':checked')) {
                if (marker.have_occurrence === 1) {
                    marker.setVisible(true);
                } else {
                    marker.setVisible(false);
                }
            } else {
                marker.setVisible(true);
            }
        }
    }
};

// Sets the map on all markers in the array.
function setMapOnAll(map) {
    for (let i = 0; i < markers.length; i++) {
        markers[i].setMap(map);
    }
}

// Removes the markers from the map, but keeps them in the array.
function clearMarkers() {
    setMapOnAll(null);
}

// Shows any markers currently in the array.
function showMarkers() {
    setMapOnAll(map);
}

// Deletes all markers in the array by removing references to them.
function deleteMarkers() {
    clearMarkers();
    markers = [];
}
