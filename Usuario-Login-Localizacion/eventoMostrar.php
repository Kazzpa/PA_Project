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
        <link rel="stylesheet" type="text/css" href="css/maps.css"/>

    </head>
    <body>
        <?php
        include("header.php");
        $evento_id = $_GET['id'];

        $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

        if (!$con) {
            die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
        }

        $consulta = "SELECT * FROM `events` WHERE id = '$evento_id'"; //consulta SQL para obtener el usuario, luego comprobamos la password

        $resultado = mysqli_query($con, $consulta);

        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

        if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
            $fila = mysqli_fetch_array($resultado);

            $nombreEvento = $fila['name'];
            $fechaCreacion = $fila['date_creation'];
            $fechaCelebracion = $fila['date_creation'];
            $creador = $fila['host'];
            $descripcion = $fila['description'];
            $evento_id = $fila['id'];
            $rutaimagen = $fila['rutaimagen'];

            echo "<h1>$nombreEvento</h1>";
            echo "<img src='$rutaimagen' alt='imagen del evento' style='width:30%;'><br />";
            echo "Creado el dia: $fechaCreacion<br />";
            echo "Su host sera: $creador y se celebrara el dia: $fechaCelebracion<br />";
            echo "Su host cree que necesitara saber lo siguiente: $descripcion";
        } else {
            echo "Evento inexistente";
        }
        ?>
        <div id="map"></div>
        <script type="text/javascript">
            function initMap() {
                var map = new google.maps.Map(document.getElementById('map'), {
                    center: {lat: 40.4167, lng: -3.70325},
                    zoom: 5,
                });
                var infoWindow = new google.maps.InfoWindow;

                // Change this depending on the name of your PHP or XML file
                downloadUrl('localizacionMostrar.php?id=<?php echo $evento_id;?>', function (data) {
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

                        var text = document.createElement('text');
                        text.textContent = address;
                        var div = document.createElement('div');
                        var a = document.createElement('a');
                        a.href = "www.google.es";
                        a.appendChild(document.createTextNode("Link"));
                        div.appendChild(a);
                        text.appendChild(div);
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
        <?php
        include("mapsScript.php");
        ?>
    </body>
</html>