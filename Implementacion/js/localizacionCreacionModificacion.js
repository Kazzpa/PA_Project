//inicializacion del mapa, reseteado
nameLocation = '';
addressLocation = '';
city = "";
lat = 0;
lng = 0;

function lookForCityChange() {
    var newName = document.getElementById("nameChange").value;
    var newAddress = document.getElementById("addressChange").value;
    var newCity = document.getElementById("cityChange").value;
    var newLat = document.getElementById("latChange").value;
    var newLng = document.getElementById("lngChange").value;
    if (newName != nameLocation) {
        nameLocation = newName;
        addressLocation = newAddress;
        city = newCity;
        lat = newLat;
        lng = newLng;
        document.getElementById("name").value = nameLocation;
        document.getElementById("address").value = addressLocation;
        document.getElementById("city").value = city;
        document.getElementById("lat").value = lat;
        document.getElementById("lng").value = lng;
    }
}

function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
        center: {lat: 40.4167, lng: -3.70325},
        zoom: 5,
    });

    var card = document.getElementById('pac-card');
    var input = document.getElementById('pac-input');

    map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.bindTo('bounds', map);

    // Setea el campo cuando el usuario selecciona una localizacion
    autocomplete.setFields(
            ['address_components', 'geometry', 'name']);

    var infowindow = new google.maps.InfoWindow();
    var infowindowContent = document.getElementById('infowindow-content');
    infowindow.setContent(infowindowContent);
    var marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();
        if (!place.geometry) {
            // Si el usuario introduce una localizacion que no se ha sugerido
            // y pulsa intro, o hay un fallo en el request de la localizacion
            window.alert("No details available for input: '" + place.name + "'");
            return;
        }

        // Si la localizacion tiene geometria, la pone en el mapa
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        //la variable location contiene las coordenadas
        var location = place.geometry.location;

        marker.setPosition(location);
        marker.setVisible(true);

        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[1] && place.address_components[1].short_name || ''),
                        //                        (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        //cambiamos el valor de los inputs con la nueva localizacion seleccionada
        document.getElementById("nameChange").value = place.name;
        document.getElementById("addressChange").value = address;
        document.getElementById("latChange").value = place.geometry.location.lat();
        document.getElementById("lngChange").value = place.geometry.location.lng();
        document.getElementById("cityChange").value = (place.address_components[2] && place.address_components[2].short_name || '');

        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindow.open(map, marker);

    });
}

function downloadUrl(url, callback) {
    var request = window.ActiveXObject ?
            new ActiveXObject('Microsoft.XMLHTTP') :
            new XMLHttpRequest;

    request.onreadystatechange = function () {
        if (request.readyState == 4) {
            request.onreadystatechange = doNothing;
            callback(request, request.status);
        }
    };

    request.open('GET', url, true);
    request.send(null);
}

function doNothing() {}