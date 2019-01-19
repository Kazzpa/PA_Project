<?php
session_start();
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
        <link rel="stylesheet" type="text/css" href="css/mapsInsideDiv.css"/>
        <script type="text/javascript" src="js/modificarCuenta.js"></script>
    </head>
    <body> 
        <?php
        include("header.php");
        if (!isset($_SESSION["login"])) {    //Si no hemos hecho login lo mostramos
            ?>
            <div class="container login-container">
                <div class="row">
                    <div class="col-md-3">  <!--Columnas creadas para centrar, una row tiene 12 filas asi que usamos 3 a la izquierda 6 wur ocupa el registro y 3 a la derecha-->
                    </div>
                    <div class="col-md-6 login-form-1">
                        <h3>Formulario de login</h3>
                        <form action = "cuentaLoginProcesamiento.php" method = "post">
                            <div class="form-group">
                                <input type="text" name="username" class="form-control" placeholder="Username" required />
                            </div>
                            <div class="form-group">
                                <input type="password" name="password" class="form-control" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="submit"  value="Acceso" name= "login" class="btnSubmit"/>
                            </div>
                        </form>
                        <a href="cuentaRegistro.php">Registrate</a>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
            <!--
                <form action = "cuentaLoginProcesamiento.php" method = "post">
                    Usuario: <input type = "text" name = "username" required/><br /> <!--Preguntar por correo electronico en vez de usuario
                    Password: <input type = "password" name = "password" required /> <br />
                    <input type = "submit" value="Enviar" name = "login" />
                </form>
                <form action = "cuentaRegistro.php" method = "post">
                    Si no esta registrado <input type="submit" value="Registrese" name="registro" /> <!--Boton que al pulsar te redirecciona a registro
                </form>
            -->
            <?php
//En vez de un html como ponia en la practica hemos introducido un php para poder avisar del error de logueo
            if (isset($_SESSION["fallido"])) {
                echo "Error al logearse";
            }
            if (isset($_SESSION["exito"])) {
                unset($_SESSION["exito"]);
                echo "Se ha registrado correctamente, pruebe a logearse con la cuenta creada";
            }
        } else {    //Si ya estamos con la sesion iniciada le permitimos hacer cambios en los datos
            ?>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-2 sidenav">
                    </div>
                    <div class="col-sm-8 text-center well">
                        <div class="row">
                            <div class="col-sm-12 text-left well" style="background-color: black; color:black">
                                <div class="col-sm-12 text-left well" style="background-color: white; color:black">
                                    <p style="font-size: 2em; text-align: center;">Datos personales</p>
                                    <?php
                                    $nombre = $_SESSION['name'];
                                    $email = $_SESSION['email'];
                                    $fechaRegistro = $_SESSION['date_register'];
                                    $rutaimagen = $_SESSION['rutaimagen'];

                                    echo "<img src=$rutaimagen width=100em> <br />";
                                    echo "<strong>Nombre:</strong> $nombre <br />";
                                    echo "<strong>Email:</strong> $email <br />";
                                    echo "<strong>Fecha Registro:</strong> $fechaRegistro <br />";
                                    ?>
                                    <p> Si quiere modificar un dato seleccionelo del campo a continuacion e introduzca el nuevo valor: </p>
                                    <form action = "cuentaModificar.php" method = "post" enctype="multipart/form-data">
                                        <div id="zonaModificacionDatos">
                                            <select id="opcionModificacionCuenta" name="selectCuentaModificar" onchange="comprobarFormularioDatos()">
                                                <option value="email">E-mail</option>
                                                <option value="password">Password</option>
                                                <option value="foto">Foto de perfil</option>
                                            </select>
                                            <br />
                                            <br />
                                            <input type="text" name="campoTexto" placeholder="E-mail" id="datoACambiar">
                                        </div>
                                        <br />
                                        <input id="botonModificacionDatos" type="submit" value="Modificar Dato" name="modificarDato" /> <!--Boton que al pulsar te redirecciona a registro-->
                                    </form>
                                    <!--
                                    <form action = "cuentaModificar.php" method = "post">
                                        <select name="selectCuentaModificar">
                                            <option value="email"> Email</option>
                                            <option value="password"> Password</option>
                                        </select>
                                        <input type="text" value="" name="campoTexto"><br />
                                        <input type="submit" value="Modificar Datos" name="registro" /> <!--Boton que al pulsar te redirecciona a registro
                                    </form>
                                    <br />
                                    <form action = "cuentaModificar.php" method = "post" enctype="multipart/form-data">
                                        Si desea cambiar su imagen de perfil: <input type="file" name="imagen" /> <br />
                                        <input type="submit" value="Modificar Foto" name="modificarFoto" /> <!--Boton que al pulsar te redirecciona a registro
                                    </form>-->
                                    <br />
                                    <form action = "cuentaEliminar.php" method = "post">
                                        <input type="submit" value="Eliminar cuenta" name="registro" /> <!--Eliminamos la cuenta del usuario si asi lo pide-->
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-12 text-left well" style="background-color: rgb(36,182,148); color:black">
                                <p style="font-size: 2em; text-align: center;">Eventos creados</p>
                                <?php
                                include_once("conexion.php");

                                $username = $_SESSION["username"];
                                $consulta = "SELECT * FROM `events` WHERE host = '$username'"; //consulta SQL para obtener el usuario, luego comprobamos la password
                                $resultado = mysqli_query($con, $consulta);

                                if (mysqli_num_rows($resultado) > 0) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                                    $i = 0;
                                    while ($auxiliar = mysqli_fetch_array($resultado)) { /* Con esto retiramos todas las filas que hayan en la base de datos, como pueden ser muchas
                                      hay que ir leyendo fila a fila */
                                        $fila[$i] = $auxiliar; //este auxiliar es para evitar que se meta la ultima iteracion vacia
                                        $i++;
                                    }
                                    ?>
                                    <p>Modificaci&oacute;n de evento</p>
                                    <form id="formModificacionEvento" action = "eventoModificar.php" method = "post" enctype="multipart/form-data">
                                        <select name='selectEvento'>
                                            <?php
                                            for ($i = 0; $i < sizeof($fila); $i++) {
                                                $event_id = $fila[$i]['id'];
                                                $event_name = $fila[$i]['name'];
                                                $event_date = $fila[$i]['date_celebration'];
                                                $event_creation = $fila[$i]['date_creation'];
                                                echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                                            }
                                            ?>
                                        </select>
                                        <br />
                                        <br />
                                        <div id="zonaModificacionDatosEvento">
                                            <select name="selectCampoEventoModificar" onchange="comprobarFormularioEventos()" id="opcionModificacionEvento">
                                                <option value="name"> Nombre Evento</option>
                                                <option value="description"> Descripcion</option>
                                                <option value="imagen"> Fotografia</option>
                                                <option value="localizacion"> Localizacion</option>
                                                <option value="eliminar"> Eliminar Evento</option>
                                            </select>
                                            <br />
                                            <br />
                                            <input type="text" name="campoTexto" placeholder="Nombre Evento" id="eventoACambiar">

                                            <!--GOOGLE MAPS-->
                                            <div id = "location" style="display:none">
                                                <div id="map"></div>
                                                <div class="pac-card" id="pac-card">
                                                    <div>
                                                        <div id="title">
                                                            Selecciona nueva localización
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
                                            </div>

                                            <div style="display:none" id="mapsData">
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
                                        <br />
                                        <input id="botonEventoModificar" type="submit" value="Modificar Evento" name="botonEventoModificar" />
                                    </form>

                                    <!-- 
                                    <p>Modificaci&oacute;n de evento</p>
                                    <form action = "eventoModificar.php" method = "post">
                     
                                      for ($i = 0; $i < sizeof($fila); $i++) {
                                      $event_id = $fila[$i]['id'];
                                      $event_name = $fila[$i]['name'];
                                      $event_date = $fila[$i]['date_celebration'];
                                      $event_creation = $fila[$i]['date_creation'];
                                      echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                                      } */
                                  
                                    <!--</select>
                                    <select name="selectCampoEventoModificar">
                                        <option value="name"> Nombre Evento</option>
                                        <option value="description"> Descripcion</option>
                                    </select>
                                    <textarea rows="4" cols="50" name="campoTexto"></textarea>
                                    <input type="submit" value="Modificar Evento" name="botonEventoModificar" />
                                </form>
                                <br />
                                <form action = "eventoModificar.php" method = "post" enctype="multipart/form-data">
                                    <select name='selectEventoModificar'>

                                      for ($i = 0; $i < sizeof($fila); $i++) {
                                      $event_id = $fila[$i]['id'];
                                      $event_name = $fila[$i]['name'];
                                      $event_date = $fila[$i]['date_celebration'];
                                      $event_creation = $fila[$i]['date_creation'];
                                      echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                                      } 
                                    <!-- </select>
                                     Si desea cambiar la imagen del evento: <input type="file" name="imagen" /> <br />
                                     <input type="submit" value="Modificar Foto Evento" name="modificarFoto" />
                                 </form> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-2 sidenav">
                        </div>
                    </div>
                </div>


                <?php
            } else {
                echo "No tiene eventos creados, animate y crea el tuyo!";
            }

            mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
            ?>
            <?php
        }
        ?>
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
