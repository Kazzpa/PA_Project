<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Infinity-Anunciantes</title>
        <?php include("../stylesheets.php"); ?>
        <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
        <!--Activar etiquetas de elementos a visualizar con el cursor-->
        <script type="text/javascript">
            $(document).ready(function () {
                $('[data-toggle="tooltip"]').tooltip();
            });
        </script>
    </head>
    <body>
        <?php
        include("../header.php");
        if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
            if ($_SESSION['tipo'] == 1) {   //Si el usuario que accede tiene permisos, le mostramos el panel de usuario
                ?>
                <!-- 
                ======================================================================
                LISTA DE ANUNCIANTES Y SUS DISTINTAS OPCIONES
                ======================================================================
                -->
                <div class="envoltura">
                    <div class="container-fluid">
                        <h2>Lista de Anunciantes</h2>                                      
                        <?php
                        //-----------------------------------------------------
                        // Consulta a la base de datos
                        //-----------------------------------------------------
                        //Realizamos una conexion a la base de datos
                        require_once "../../conexion.php";
                        
                        //Seleccionamos todos los anunciantes 
                        $consulta = "SELECT * FROM advertisers";

                        //-----------------------------------------------------
                        // Iteracion consulta y muestra por pantalla
                        //-----------------------------------------------------
                        if ($resultado = mysqli_query($con, $consulta)) {
                            if (!(mysqli_num_rows($resultado)) == 0) {
                                echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";
                                echo "<tr><th>ID</th><th>Nombre</th><th>Organizacion</th><th>Alias</th><th>Acción</th></tr>";
                                echo "</thead>";
                                echo "<tbody>";
                                while ($fila = mysqli_fetch_array($resultado)) {
                                    echo "<tr><td>" . $fila['id'] . "</td>" . "<td>" . $fila['name'] . "</td>" . "<td>" . $fila['organization'] . "</td>" . "<td>" . $fila['alias'] . "</td>";
                                    echo "<td>";
                                    echo "<a href='anuncianteLectura.php?id=" . $fila['id'] . "' title='Vista de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-info-sign'></span></a>";
                                    echo "<a href='anuncianteModificar.php?id=" . $fila['id'] . "' title='Actualizacion de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                    echo "<a href='anuncianteBorrar.php?id=" . $fila['id'] . "' title='Borrado de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a>";
                                    echo "</td></tr>";
                                }
                                echo "</tbody></table>";
                                echo "<a href='anuncianteCrear.php' class='btn btn-primary pull-right'>Añadir Anunciante</a>";
                                mysqli_free_result($resultado);
                            } else {
                                echo "<a href='anuncianteCrear.php' class='btn btn-primary pull-right'>Añadir Anunciante</a>";
                                echo "<p class='lead'><em>Registros no encontrados.</em></p>";
                            }
                        } else {
                            echo "ERROR:No se pudo ejecutar $consulta. " . mysqli_error($con);
                        }
                        // Cerrar conexion
                        mysqli_close($con);
                    } else {
                        echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
                    }
                } else {
                    echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
                }
                ?>                
            </div>
        </div>
    </body>
</html>