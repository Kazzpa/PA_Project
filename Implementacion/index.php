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
        <title>Infinity-Index</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
        <script type="text/javascript" src="js/index.js"></script>
    </head>
    <body>
        <!-- Index actua de showcase de eventos patrocinados, tanto creados por personas como patrocinados. Se muestran los 3 eventos de cada tipo
        mas cercanos en tiempo. Dependiendo del tipo de evento se mostrara informacion diferente
        -->
        <!-- Incluimos la cabecera con todas las opciones de navegación-->
        <?php include("header.php"); ?>
        <br />
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                </div>
                <div class="col-sm-8 text-center well" style="background-color: black; color:white">  <!--text-center, text-left... se puede cambiar, well le da el toque de redondez a los bordes-->
                    <h1>Bienvenido</h1>
                    <input id="botonEventosPatrocinados" type="button" class="btn btn-default" value="Eventos de anunciante" style="background-color: white; color:black"/>
                    <input id="botonEventosUsuarios" class="btn btn-default" type="button" value="Eventos de usuarios"/>
                    <!-- 
                    ======================================================================
                    EVENTOS PATROCINADOS
                    ======================================================================
                    -->
                    <div id="divEventosPatrocinados">
                        <?php
                        //-----------------------------------------------------
                        // Consulta a la base de datos
                        //-----------------------------------------------------
                        //Realizamos una conexion a la base de datos
                        include("conexion.php");

                        //Consulta a la BD que obtiene los 3 eventos patrocinados más proximos
                        $consulta = "SELECT * FROM `events`,`advertisers` WHERE date_celebration>CURRENT_TIMESTAMP AND idAdvertisers>0 AND events.idAdvertisers=advertisers.id ORDER BY date_celebration LIMIT 3"; //consulta SQL para obtener el usuario, luego comprobamos la password
                        $resultado = mysqli_query($con, $consulta);


                        //-----------------------------------------------------
                        // Iteracion consulta y muestra por pantalla
                        //-----------------------------------------------------
                        if (!(mysqli_num_rows($resultado)) == 0) {
                            $i = 0;
                            //Retiramos las filas de la consulta realizada
                            while ($auxiliar = mysqli_fetch_array($resultado)) {
                                //Este auxiliar es para evitar que se meta la ultima iteracion vacia
                                $fila[$i] = $auxiliar;
                                $i++;
                            }
                            //Iteramos las filas obtenidas para mostrarlas por pantalla
                            for ($i = 0; $i < sizeof($fila); $i++) {
                                //Hay dos tablas por el UNION en la consulta, lo obtenemos del indice numerico que es donde se guarda
                                $nombreEvento = $fila[$i][1];
                                $fechaCelebracion = $fila[$i]['date_celebration'];
                                $organization = $fila[$i]['organization'];
                                $descripcion = $fila[$i]['description'];
                                $evento_id = $fila[$i][0];
                                $rutaimagen = $fila[$i]['rutaimagen'];

                                //Mostramos por pantalla la informacion del evento en forma de tabla
                                echo "<div class='text-center well'>
                                <table style='color:black; margin:auto;'> 
                                <tr>
                                    <th style='text-align:center; font-size: 2em;'><a class='link' href='Entidades/Evento/eventoMostrar.php?id=$evento_id'>$nombreEvento</th>
                                </tr>
                                <tr>
                                    <td><img src='Entidades/Evento/$rutaimagen' class='img-responsive' alt='imagen del evento' style='width:200px%; height:200px;'></td>
                                </tr>
                                <tr>
                                    <td>$descripcion</td>
                                </tr>
                                <tr>
                                    <td>Celebracion: $fechaCelebracion</td>
                                </tr>
                                <tr>
                                    <td>Organiza: $organization</td>
                                </tr>
                                </table> 
                                </div>";
                            }
                        } else {    //Si no hay eventos mostramos un mensaje informativo
                            echo "No hay eventos programados por empresas, animate y crea el tuyo!";
                        }
                        ?>
                    </div>
                    <!-- 
                    ======================================================================
                    EVENTOS CREADOS POR USUARIOS
                    ======================================================================
                    -->
                    <div id="divEventosUsuarios" hidden>
                        <?php

                        //Consulta a la BD que obtiene los 3 eventos creados por usuarios más proximos
                        $consulta = "SELECT * FROM `events` WHERE date_celebration>CURRENT_TIMESTAMP AND idAdvertisers=0 ORDER BY date_celebration LIMIT 3"; //consulta SQL para obtener el usuario, luego comprobamos la password
                        $resultado = mysqli_query($con, $consulta);

                        //Cerramos la conexion a la base de datos
                        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
                        //-----------------------------------------------------
                        // Iteracion consulta y muestra por pantalla
                        //-----------------------------------------------------
                        if (!(mysqli_num_rows($resultado)) == 0) {
                            $i = 0;

                            //Retiramos las filas de la consulta realizada
                            while ($auxiliar = mysqli_fetch_array($resultado)) {
                                //Este auxiliar es para evitar que se meta la ultima iteracion vacia
                                $fila[$i] = $auxiliar;
                                $i++;
                            }

                            //Iteramos las filas obtenidas para mostrarlas por pantalla
                            for ($i = 0; $i < sizeof($fila); $i++) {
                                //Hay dos tablas por el UNION en la consulta, lo obtenemos del indice numerico que es donde se guarda
                                $nombreEvento = $fila[$i]['name'];
                                $fechaCelebracion = $fila[$i]['date_celebration'];
                                $descripcion = $fila[$i]['description'];
                                $evento_id = $fila[$i]['id'];
                                $rutaimagen = $fila[$i]['rutaimagen'];

                                //Mostramos por pantalla la informacion del evento en forma de tabla
                                echo "<div class='text-center well'>
                                <table style='color:black; margin:auto;'> 
                                <tr>
                                    <th style='text-align:center; font-size: 2em;'><a class='link' href='Entidades/Evento/eventoMostrar.php?id=$evento_id'>$nombreEvento</th>
                                </tr>
                                <tr>
                                    <td><img src='Entidades/Evento/$rutaimagen' class='img-responsive' alt='imagen del evento' style='width:200px%; height:200px;'></td>
                                </tr>
                                <tr>
                                    <td>$descripcion</td>
                                </tr>
                                <tr>
                                    <td>Celebracion: $fechaCelebracion</td>
                                </tr>
                                </table> 
                                </div>";
                            }
                        } else {    //Si no hay eventos mostramos un mensaje informativo
                            echo "No hay eventos programados por usuarios, animate y crea el tuyo!";
                        }
                        ?>
                    </div>
                </div>
                <div class="col-sm-2 sidenav">
                </div>                 
            </div>
        </div>

        <footer class="container-fluid text-center">
            <p>Footer Text</p>
        </footer>
    </body>
</html>