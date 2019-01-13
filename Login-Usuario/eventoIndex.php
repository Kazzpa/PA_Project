<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
        <link rel="stylesheet" type="text/css" href="css/maps.css"/> <!--Esta es una forma de hacer la otra es <head> <style type="text/css"> pero es menos recomendable-->

    </head>
    <body>
        <?php include("header.php"); ?>
        <div id="map"></div>
        <div class="container-fluid text-center"> 
            <div class="col-sm-2 sidenav">
            </div>
            <div class="col-sm-8 text-center well" style="background-color: white; border: none">
                <?php
                if (isset($_SESSION["login"])) {
                    ?>
                    <a class="link" href="eventoCreacion.php" style="float:right;"><i class="material-icons" style="font-size: 4em;">add_circle_outline</i></a>
                    <br />
                    <?php
                }
                ?>
            </div>
            <div class="col-sm-2 sidenav">
            </div>
        </div>
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                </div>
                <div class="col-sm-8 text-center well" style="background-color: black; color:white">  <!--text-center, text-left... se puede cambiar, well le da el toque de redondez a los bordes-->
                    <?php
                    include_once("conexion.php");

                    $consulta = "SELECT * FROM `events`"; //consulta SQL para obtener el usuario, luego comprobamos la password
                    $resultado = mysqli_query($con, $consulta);

                    mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

                    if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                        $i = 0;
                        while ($auxiliar = mysqli_fetch_array($resultado)) { /* Con esto retiramos todas las filas que hayan en la base de datos, como pueden ser muchas
                          hay que ir leyendo fila a fila */
                            $fila[$i] = $auxiliar; //este auxiliar es para evitar que se meta la ultima iteracion vacia
                            $i++;
                        }

                        for ($i = 0; $i < sizeof($fila); $i++) {
                            $nombreEvento = $fila[$i]['name'];
                            $fechaCreacion = $fila[$i]['date_creation'];
                            $fechaCelebracion = $fila[$i]['date_celebration'];
                            $creador = $fila[$i]['host'];
                            $descripcion = $fila[$i]['description'];
                            $evento_id = $fila[$i]['id'];
                            $rutaimagen = $fila[$i]['rutaimagen'];

                            echo "<div class='text-center well'>
                                <table style='color:black; margin:auto;'> 
        <tr>
            <th style='text-align:center; font-size: 2em;'><a class='link' href='eventoMostrar.php?id=$evento_id'>$nombreEvento</th>
        </tr>
        <tr>
            <td><img src='$rutaimagen' alt='imagen del evento' style='width:200px%; height:200px;'></td>
        </tr>
        <tr>
            <td>$descripcion</td>
        </tr>
        <tr>
            <td>Creacion: $fechaCreacion</td>
        </tr>
        <tr>
            <td>Celebracion: $fechaCelebracion</td>
        </tr>
        <tr>
            <td>Creador: $creador</td>
        </tr>
</table> 
</div>";
                        }
                    } else {
                        echo "No hay eventos creados, animate y crea el tuyo!";
                    }
                    include("mapsScript.php");
                    ?>
                </div>
                <div class="col-sm-2 sidenav">
                </div>
            </div>
        </div>
        <script type="text/javascript">
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 40.4167, lng: -3.70325},
                    zoom: 5,
                });
                var infoWindow = new google.maps.InfoWindow;


                downloadUrl('localizacionMostrar.php', function (data) {
                    var xml = data.responseXML;
                    var markers = xml.documentElement.getElementsByTagName('marker');
                    Array.prototype.forEach.call(markers, function (markerElem) {
                        var name = markerElem.getAttribute('name');
                        var address = markerElem.getAttribute('address');
                        var point = new google.maps.LatLng(
                                parseFloat(markerElem.getAttribute('lat')),
                                parseFloat(markerElem.getAttribute('lng')));

                        var infowincontent = document.createElement('div');
                        var strong = document.createElement('strong');
                        strong.textContent = name
                        infowincontent.appendChild(strong);
                        infowincontent.appendChild(document.createElement('br'));
                        //creamos el enlace a los eventos
                        var text = document.createElement('text');
                        text.textContent = address;

                        //creamos un enlace por cada evento asociado a esa localizacion
                        var numEvents = markerElem.getAttribute('numEvents');
                        for (var i = 0; i < numEvents; i++) {
                            var div = document.createElement('div');

                            var a = document.createElement('a');
                            a.href = "eventoMostrar.php?id=" + markerElem.getAttribute('idEvent' + i);
                            a.appendChild(document.createTextNode(markerElem.getAttribute('nameEvent' + i)));
                            div.appendChild(a);
                            div.appendChild(document.createTextNode(" - " + markerElem.getAttribute('date_celebration' + i)));
                            text.appendChild(div);
                        }

                        infowincontent.appendChild(text);
                        var marker = new google.maps.Marker({
                            map: map,
                            position: point,
                            animation: google.maps.Animation.DROP,
                        });
                        marker.addListener('click', function () {
                            infoWindow.setContent(infowincontent);
                            infoWindow.open(map, marker);
                        });
                    });
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

        </script>
    </body>
</html>
