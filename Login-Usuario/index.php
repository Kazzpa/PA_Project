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
        <script type="text/javascript" src="js/index.js"></script>
    </head>
    <body>
        <?php include("header.php"); ?>
        <br />
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                </div>
                <div class="col-sm-8 text-center well" style="background-color: black; color:white">  <!--text-center, text-left... se puede cambiar, well le da el toque de redondez a los bordes-->
                    <h1>Welcome</h1>
                    <input id="botonEventosPatrocinados" type="button" value="Explora" style="background-color: white; color:black"/>
                    <input id="botonEventosUsuarios" type="button" value="Descubre"/>
                    <!-- CONSULTA DE EVENTOS PATROCINADOS-->
                    <div id="divEventosPatrocinados">
                        <?php
                        include_once("conexion.php");

                        $consulta = "SELECT * FROM `events`,`advertisers` WHERE date_celebration>CURRENT_TIMESTAMP AND idAdvertisers>0 AND events.idAdvertisers=advertisers.id ORDER BY date_celebration LIMIT 3"; //consulta SQL para obtener el usuario, luego comprobamos la password
                        $resultado = mysqli_query($con, $consulta);

                        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

                        if (mysqli_num_rows($resultado) > 0) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                            $i = 0;
                            while ($auxiliar = mysqli_fetch_array($resultado)) { /* Con esto retiramos todas las filas que hayan en la base de datos, como pueden ser muchas
                              hay que ir leyendo fila a fila */
                                $fila[$i] = $auxiliar; //este auxiliar es para evitar que se meta la ultima iteracion vacia
                                $i++;
                            }
                            
                            for ($i = 0; $i < sizeof($fila); $i++) {
                                $nombreEvento = $fila[$i][1];   //Como hay dos tablas que tienen name se guarda en esta el nombre de evento
                                $fechaCelebracion = $fila[$i]['date_celebration'];
                                $organization = $fila[$i]['organization'];
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
            <td>Celebracion: $fechaCelebracion</td>
        </tr>
        <tr>
            <td>Organiza: $organization</td>
        </tr>
</table> 
</div>";
                            }
                        } else {
                            echo "No hay eventos programados por empresas, animate y crea el tuyo!";
                        }
                        ?>
                    </div>
                    <!--CONSULTA DE EVENTOS CREADOS POR USUARIOS-->
                    <div id="divEventosUsuarios" hidden>
                        <?php
                        $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

                        if (!$con) {
                            die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
                        }
                        //Ordenamos de forma que salen los 3 eventos mas proximos
                        $consulta = "SELECT * FROM `events` WHERE date_celebration>CURRENT_TIMESTAMP AND idAdvertisers=0 ORDER BY date_celebration LIMIT 3"; //consulta SQL para obtener el usuario, luego comprobamos la password
                        $resultado = mysqli_query($con, $consulta);

                        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

                        if (mysqli_num_rows($resultado) > 0) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                            $i = 0;
                            while ($auxiliar = mysqli_fetch_array($resultado)) { /* Con esto retiramos todas las filas que hayan en la base de datos, como pueden ser muchas
                              hay que ir leyendo fila a fila */
                                $fila[$i] = $auxiliar; //este auxiliar es para evitar que se meta la ultima iteracion vacia
                                $i++;
                            }

                            for ($i = 0; $i < sizeof($fila); $i++) {
                                $nombreEvento = $fila[$i]['name'];
                                $fechaCelebracion = $fila[$i]['date_celebration'];
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
            <td>Celebracion: $fechaCelebracion</td>
        </tr>
</table> 
</div>";
                            }
                        } else {
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