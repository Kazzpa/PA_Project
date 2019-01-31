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
        <title>Infinity-Evento Creacion</title>
        <?php include("../stylesheets.php"); ?>
        <!--Importes MAPS -->
        <link rel="stylesheet" type="text/css" href="../../css/maps.css"/>
    </head>
    <body>
        <!--
        ======================================================================
        VENTANA DE CREACION DE UN EVENTO
        ======================================================================
        -->
        <?php
        include("../header.php");
        if (isset($_SESSION["login"])) {
            ?>
            <!--
            Div donde mostraremos el mapa
            -->
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
            <!--
            Mostramos dos contenedores, el primero contendra informacion del evento,
            el segundo contendra la localizacion del evento, que es opcional
            -->
            <div class="container login-container">
                <form id="eventCreationForm" action = "eventoCreacionProcesamiento.php" method = "post" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-6 login-form-1">
                            <h3>Datos del evento</h3>
                            <div class="form-group">
                                <input type="text" minlength="3" maxlength="50" class="form-control" name= "nameEvent" placeholder="Nombre evento" value="" required/>
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" maxlength="500" name = "description" rows="6" style="resize: none;" id="comment" placeholder="Introduce una descripcion" required></textarea>
                            </div>
                            <div class="form-group">
                                <p>Formato date ejemplo: 2018-06-12T19:30 </p>
                                <input type = "datetime-local" name = "date-celebration" required placeholder="2018-06-12T19:30"/>
                            </div>
                            <div class="form-group">
                                <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                            </div>
                            <?php
                            include '../Grupo/grupo_db.php';
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
                        <script>
                            $("#eventCreationForm").validate();
                        </script>
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
                             * Para ello, se inicia un intervalo (funcion lookForCityChange) que 
                             * comprueba si hay cambios en el valor introducido en el campo del mapa de google.
                             */
                            setInterval(lookForCityChange, 100);
            </script>
            <?php
            include("../Localizacion/mapsScript.php");
        } else {
            echo "Loguese en la pagina para acceder a esta funcionalidad";
        }
        ?>
    </body>
</html>
