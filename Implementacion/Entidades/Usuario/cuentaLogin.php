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
        <title>Infinity-Login <?php
            if (isset($_SESSION['name'])) {
                echo '-' . $_SESSION['name'];
            }
            ?></title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("../stylesheets.php"); ?>
        <link rel="stylesheet" type="text/css" href="../../css/mapsInsideDiv.css"/>
        <script type="text/javascript" src="../../js/modificarCuenta.js"></script>
    </head>
    <body> 
        <?php
        include("../header.php");
        include_once '../Grupo/adminGrupo.php';
        include_once '../Logro/logros_admin.php';
        //======================================================================
        // LOGIN INICIO SESION
        //======================================================================
        if (!isset($_SESSION["login"])) {
            ?>
            <!--Aplicacion Boostrap-->
            <!--Columnas creadas para centrar, una row tiene 12 filas. Usamos 3 a la izquierda 6  ocupa el registro y 3 a la derecha-->
            <div class="container login-container">
                <div class="row">
                    <div class="col-md-3">  
                    </div>
                    <div class="col-md-6 login-form-1">
                        <h3>Formulario de login</h3>
                        <form id="loginForm" action = "cuentaLoginProcesamiento.php" method = "post">
                            <div class="form-group">
                                <input type="text" maxlength="20" name="username" class="form-control" placeholder="Username" required />
                            </div>
                            <div class="form-group">
                                <input type="password" minlength="5" maxlength="20" name="password" class="form-control" placeholder="Password" required/>
                            </div>
                            <div class="form-group">
                                <input type="submit"  value="Acceso" name= "login" class="btnSubmit"/>
                            </div>
                        </form>
                        <script>
                            $("#loginForm").validate();
                        </script>
                        <a href="cuentaRegistro.php">Registrate</a>
                        <?php
                        //Control de fallo de logueo
                        if (isset($_SESSION["fallido"])) {
                            echo "Error al logearse";
                        }
                        //Si el usuario se acaba de registrar mandamos un mensaje.
                        if (isset($_SESSION["exito"])) {
                            unset($_SESSION["exito"]);
                            echo "Se ha registrado correctamente, pruebe a logearse con la cuenta creada";
                        }
                        ?>
                    </div>
                    <div class="col-md-3">
                    </div>
                </div>
            </div>
            <?php
        } else {
            //======================================================================
            // PANEL DE CONTROL ESTANDO YA LOGUEADO
            //======================================================================
            ?>
            <div class="container-fluid"> 
                <div class="row">
                    <div class="col-sm-2 sidenav">
                    </div>
                    <div class="col-sm-8 text-center well">
                        <div class="row ">
                            <!--
                            -----------------------------------------------------
                            Panel de control, datos personales
                            -----------------------------------------------------
                            -->
                            <div class="col-sm-12 text-left well" style="background-color: black; color:black">
                                <div class="col-sm-12 text-left well" style="background-color: white; color:black">
                                    <p style="font-size: 2em; text-align: center;">Datos personales</p>
                                    <?php
                                    $nombre = $_SESSION['name'];
                                    $email = $_SESSION['email'];
                                    $fechaRegistro = $_SESSION['date_register'];
                                    $rutaimagen = $_SESSION['rutaimagen'];

                                    echo "<img src=$rutaimagen class='img-responsive' width=100em> <br />";
                                    echo "<strong>Nombre:</strong> $nombre <br />";
                                    echo "<strong>Email:</strong> $email <br />";
                                    echo "<strong>Fecha Registro:</strong> $fechaRegistro <br />";
                                    ?>
                                    <!-- Campo select modificacion de usuario -->
                                    <p> Si quiere modificar un dato seleccionelo del campo a continuacion e introduzca el nuevo valor: </p>
                                    <form id="accountModify" action = "cuentaModificar.php" method = "post" enctype="multipart/form-data">
                                        <div id="zonaModificacionDatos">
                                            <select id="opcionModificacionCuenta" name="selectCuentaModificar" onchange="comprobarFormularioDatos()">
                                                <option value="email">E-mail</option>
                                                <option value="password">Password</option>
                                                <option value="foto">Foto de perfil</option>
                                            </select>
                                            <br />
                                            <br />
                                            <input type="email" name="campoTexto" placeholder="E-mail" maxlength="255" id="datoACambiar" required>
                                        </div>
                                        <br />
                                        <input id="botonModificacionDatos" type="submit" value="Modificar Dato" name="modificarDato" /> <!--Boton que al pulsar te redirecciona a registro-->
                                    </form>
                                    <script>
                                        $("#accountModify").validate();
                                    </script>
                                    <!-- Boton para el borrado de la cuenta-->
                                    <input type="submit" value="Eliminar cuenta" name="registro" onClick="avisarBorradoCuenta()"/> <!--Eliminamos la cuenta del usuario si asi lo pide-->
                                </div>
                            </div>
                        </div>
                        <!--
                        -----------------------------------------------------
                        Panel de control, eventos
                        -----------------------------------------------------
                        -->
                        <div class="row">
                            <div class="col-sm-12 text-left well" style="background-color: rgb(36,182,148); color:black">
                                <p style="font-size: 2em; text-align: center;">Eventos creados</p>
                                <?php
                                //Conexion a la base de datos
                                include("../../conexion.php");

                                //Consulta a la BD para extraer los eventos organizados por el usuario
                                $username = $_SESSION["username"];
                                $consulta = "SELECT * FROM `events` WHERE host = '$username'";
                                $resultado = mysqli_query($con, $consulta);

                                //Cerramos la conexion a la base de datos ya que no nos hace falta
                                mysqli_close($con);

                                //Si la consulta ha tenido exito
                                if (!(mysqli_num_rows($resultado)) == 0) {
                                    $i = 0;
                                    //Retiramos las filas obtenidas en la consulta
                                    while ($auxiliar = mysqli_fetch_array($resultado)) {
                                        $fila[$i] = $auxiliar;
                                        $i++;
                                    }
                                    ?>

                                    <!-- Campo select modificacion de evento -->
                                    <p>Modificaci&oacute;n de evento</p>
                                    <form id="formModificacionEvento" action = "../Evento/eventoModificar.php" method = "post" enctype="multipart/form-data">
                                        <!-- Colocamos en un campo select los eventos creados por el usuario-->
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
                                        <!-- Mostramos las opciones de modificacion del evento-->
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
                                            <input type="text" minlength="3" maxlength="50" name="campoTexto" placeholder="Nombre Evento" id="eventoACambiar" required>

                                            <!--Bloque Google Maps mostrado al elegir la modificacion Localizacion-->
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
                                    <script>
                                        $("#formModificacionEvento").validate();
                                    </script>



                                    <?php
                                } else {    //Mensaje mostrado si no existen eventos creados
                                    echo "No tiene eventos creados, animate y crea el tuyo!";
                                }
                                ?> </div>
                        </div><?php
                    }
                    if (isset($_SESSION['username'])) {
                        ?>

                        <!--
                        -----------------------------------------------------
                        Panel de administrar grupos
                        -----------------------------------------------------
                        -->

                        <div class="col-sm-12">
                            <h4> <b>Panel grupos</b></h4>
                            <div class="col-sm-12 text-left well">
                                <?php
                                panelLoginGrupo();
                                ?>

                            </div>
                        </div>
                        <script>
                            $("#nombreGrupo").validate();
                            $("#modGrupo").validate();
                        </script>
                        <?php if ($_SESSION['tipo'] == 1) { ?>
                            <!--
                            -----------------------------------------------------
                            Panel de administrar logros
                            -----------------------------------------------------
                            -->
                            <div class="col-sm-12">
                                <h4> <b>Panel Logros </b></h4>
                                <div class="col-sm-12 text-left well">
                                    <?php
                                    panelLogrosLogin();
                                    ?>

                                </div>
                            </div>
                            <script>
                                $("#crearLogro").validate();
                                $("#buscarLogro").validate();
                                $("#modBorrarLogro").validate();
                            </script>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div class="col-sm-2 sidenav">
            </div>
            <!--
            -----------------------------------------------------
            Google maps API
            -----------------------------------------------------
            -->
            <script type="text/javascript" src="../../js/localizacionCreacionModificacion.js"></script>
            <script type="text/javascript">
                        /*
                         * La localizacion modifica el valor de los campos del formulario en 
                         * base a la informacion introducida en el autocompletar de Google. 
                         * Para ello, ante la llamada de modificar una localizacion, se inicia
                         * un intervalo (funcion lookForCityChange) que comprueba si hay 
                         * cambios en el valor introducido en el campo del mapa de google.
                         */
                        function modificarLocalizacion() {
                            setInterval(lookForCityChange, 100);
                        }
            </script>
            <!--Declaracion del google Maps-->
            <?php include("../Localizacion/mapsScript.php"); ?>
    </body>
</html>