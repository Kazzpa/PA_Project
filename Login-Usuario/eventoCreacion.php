<?php session_start(); ?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include("stylesheets.php"); ?>
        <link rel="stylesheet" type="text/css" href="css/maps.css"/>
    </head>
    <body>
        <?php
        include("header.php");
        ?>
        <div id="map"></div>
        <div class="pac-card" id="pac-card">
            <div>
                <div id="title">
                    Selecciona localización
                </div>
            </div>
            <div id="pac-container">
                <input id="pac-input" type="text"
                       placeholder="Introduce una localización">
            </div>
        </div>
        <div id="infowindow-content">
            <img src="" width="16" height="16" id="place-icon">
            <span id="place-name"  class="title"></span><br>
            <span id="place-address"></span>
        </div>
        <div class="container login-container">
            <form action = "eventoCreacionProcesamiento.php" method = "post" enctype="multipart/form-data">
                <div class="row-eq-height">
                    <div class="col-md-6 login-form-1">
                        <h3>Datos del evento</h3>
                        <div class="form-group">
                            <input type="text" class="form-control" name= "nameEvent" placeholder="Nombre evento" value="" required/>
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" name = "description" rows="6" style="resize: none;" id="comment" placeholder="Introduce una descripcion" required></textarea>
                        </div>
                        <div class="form-group">
                            <input type = "datetime-local" name = "date-celebration" required placeholder="2018-06-12T19:30"/>
                        </div>
                        <div class="form-group">
                            <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                        </div>
                        <?php
                        include 'grupo_db.php';
                        $gruposMod = getGroupsSubbed($_SESSION['username']);
                        if ($gruposMod !== false) {
                            echo '<div class="form-group">
                                Grupo del evento:
                            <select class="custom-select" name="grupoEvento" required>
                            <option value="0">Sin grupo</option>
                                ';
                            for ($i = 0; $i < sizeof($gruposMod); $i++) {
                                echo '<option value="' . $gruposMod[$i][1] . '">' . $gruposMod[$i][0] . '</option>';
                            }
                            echo '
                            </select>
                        </div>';
                        }
                        ?>
                        <div class="form-group">
                            <input type="submit" class="btnSubmit" value="Crear" />
                        </div>
                    </div>
                    <div class="col-md-6 login-form-2">
                        <h3>Localizacion</h3>
                        <div class="form-group">
                            Nombre:<br/><input type="text" name="name" id="name" placeholder="Nombre del sitio" readonly="readonly" class="form-control-file"><br><br>
                            <input type="hidden" id="nameChange">
                        </div>
                        <div class="form-group">
                            Direccion:<br/><input type="text" name="address" id="address" placeholder="Direccion del sitio" class="form-control-file" readonly="readonly"><br><br>
                            <input type="hidden" id="addressChange">
                        </div>
                        <div class="form-group">
                            Ciudad:<br/><input type="text" name="city" id="city" class="form-control-file" placeholder="Ciudad del sitio" readonly="readonly"><br><br>
                            <input type="hidden" id="cityChange">
                        </div>
                        <div class="form-group">
                            Latitud:<br/><input type="text" name="lat" id="lat" class="form-control-file" placeholder="Coordenadas de latitud" value="" readonly="readonly"><br><br>
                            <input type="hidden" id="latChange">
                        </div>
                        <div class="form-group">
                            Longitud:<br/><input type="text" name="lng" id="lng" class="form-control-file" placeholder="Coordenadas de longitud" value=""readonly="readonly"><br><br>
                            <input type="hidden" id="lngChange">
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <!--para que el mapa no se esconda, hace falta poner el style del form a 100% en altura y anchura-->
        <!--
        <form action = "eventoCreacionProcesamiento.php" method = "post" enctype="multipart/form-data" style="height:100%; width:100%;">
            Nombre del evento: <input type = "text" name= "nameEvent" required/><br />
            Descripcion: <br/>
            <textarea rows="4" cols="50" name = "description" placeholder="Introduzca una breve descripcion sobre el evento a realizar" required/></textarea><br />
        Foto: <input type="file" name="imagen" /> <br />
        <br />
        Fecha de celebracion: <input type = "datetime-local" name = "date-celebration" required /><br />
        <label>Nombre: </label>
        <input type="text" name="name" id="name" placeholder="Nombre del sitio" readonly="readonly"><br><br>
        <input type="hidden" id="nameChange">

        <label>Direccion: </label>
        <input type="text" name="address" id="address" placeholder="Direccion del sitio" readonly="readonly"><br><br>
        <input type="hidden" id="addressChange">

        <label>Ciudad: </label>
        <input type="text" name="city" id="city" placeholder="Ciudad del sitio" readonly="readonly"><br><br>
        <input type="hidden" id="cityChange">

        <label>Latitud: </label>
        <input type="text" name="lat" id="lat" placeholder="Coordenadas de latitud" value="" readonly="readonly"><br><br>
        <input type="hidden" id="latChange">

        <label>Longitud: </label>
        <input type="text" name="lng" id="lng" placeholder="Coordenadas de longitud" value=""readonly="readonly"><br><br>
        <input type="hidden" id="lngChange">

        <input type = "submit" value="Registro" name = "registroProcesamiento" />
    </form>
        -->

        <script type="text/javascript">
            nameLocation = '';
            addressLocation = '';
            city = "";
            lat = 0;
            lng = 0;


            setInterval(lookForCityChange, 100);

            function lookForCityChange() {
                var newName = document.getElementById("nameChange").value;
                var newAddress = document.getElementById("addressChange").value;
                var newCity = document.getElementById("cityChange").value;
                var newLat = document.getElementById("latChange").value;
                var newLng = document.getElementById("lngChange").value;
                if (newName != nameLocation) {
                    console.log(newAddress);
                    //console.log(newCity);
                    console.log(newLat);
                    console.log(newLng);
                    nameLocation = newName;
                    addressLocation = newAddress;
                    city = newCity;
                    lat = newLat;
                    lng = newLng;
                    // do whatever you need to do
                    document.getElementById("name").value = nameLocation;
                    document.getElementById("address").value = addressLocation;
                    document.getElementById("city").value = city;
                    document.getElementById("lat").value = lat;
                    document.getElementById("lng").value = lng;
                }
            }

            //document.getElementById("nameChange").addEventListener("change", victoria);

            //        function victoria() {
            //            alert(nameLocation.value);
            //            document.getElementById("name").value = nameLocation.value;
            //        }


            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 40.4167, lng: -3.70325},
                    zoom: 5,
                });
//                var infoWindow = new google.maps.InfoWindow;

                // Change this depending on the name of your PHP or XML file
//                downloadUrl('consultaLocalizaciones.php', function (data) {
//                    var xml = data.responseXML;
//                    var markers = xml.documentElement.getElementsByTagName('marker');
//                    Array.prototype.forEach.call(markers, function (markerElem) {
//                        var name = markerElem.getAttribute('name');
//                        var address = markerElem.getAttribute('address');
//                        var point = new google.maps.LatLng(
//                                parseFloat(markerElem.getAttribute('lat')),
//                                parseFloat(markerElem.getAttribute('lng')));
//
//                        var infowincontent = document.createElement('div');
//                        var strong = document.createElement('strong');
//                        strong.textContent = name
//                        infowincontent.appendChild(strong);
//                        infowincontent.appendChild(document.createElement('br'));
//
//                        var text = document.createElement('text');
//                        text.textContent = address;
//                        var div = document.createElement('div');
//                        var a = document.createElement('a');
//                        a.href = "www.google.es";
//                        a.appendChild(document.createTextNode("Link"));
//                        div.appendChild(a);
//                        text.appendChild(div);
//                        infowincontent.appendChild(text);
//                        var marker = new google.maps.Marker({
//                            map: map,
//                            position: point,
//                            animation: google.maps.Animation.DROP,
//                        });
//                        marker.addListener('click', function () {
//                            infoWindow.setContent(infowincontent);
//                            infoWindow.open(map, marker);
//                        });
//                    });
//                });


                var card = document.getElementById('pac-card');
                var input = document.getElementById('pac-input');

                map.controls[google.maps.ControlPosition.TOP_RIGHT].push(card);

                var autocomplete = new google.maps.places.Autocomplete(input);

                // Bind the map's bounds (viewport) property to the autocomplete object,
                // so that the autocomplete requests use the current map bounds for the
                // bounds option in the request.
                autocomplete.bindTo('bounds', map);

                // Set the data fields to return when the user selects a place.
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
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    // If the place has a geometry, then present it on a map.
                    if (place.geometry.viewport) {
                        map.fitBounds(place.geometry.viewport);
                    } else {
                        map.setCenter(place.geometry.location);
                        map.setZoom(17);  // Why 17? Because it looks good.
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


                    document.getElementById("nameChange").value = place.name;
                    document.getElementById("addressChange").value = address;
                    document.getElementById("latChange").value = place.geometry.location.lat();
                    document.getElementById("lngChange").value = place.geometry.location.lng();
                    document.getElementById("cityChange").value = (place.address_components[2] && place.address_components[2].short_name || '');

                    //                nameLocation = place.name;
                    //                addressLocation = address;
                    //                lat = place.geometry.location.lat();
                    //                lng = place.geometry.location.lng();
                    //                city = place.address_components[3];

                    infowindowContent.children['place-icon'].src = place.icon;
                    infowindowContent.children['place-name'].textContent = place.name;
                    infowindowContent.children['place-address'].textContent = address;
                    infowindow.open(map, marker);

                });

                //            setupClickListener('changetype-all', []);
                //            setupClickListener('changetype-address', ['address']);
                //            setupClickListener('changetype-establishment', ['establishment']);
                //            setupClickListener('changetype-geocode', ['geocode']);
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

        </script>
        <?php include("mapsScript.php"); ?>
    </body>
</html>
