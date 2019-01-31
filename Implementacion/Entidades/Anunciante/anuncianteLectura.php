<?php
session_start();

//======================================================================
//VISTA EXTENDIDA ANUNCIANTE
//======================================================================

//Chequea que exista parametro id
if (isset($_GET["id"]) && !empty(trim($_GET["id"]))) {
    
    //-----------------------------------------------------
    // Consulta a la base de datos
    //-----------------------------------------------------
    //Realizamos una conexion a la base de datos
    require_once "../../conexion.php";

    //Preparacion sentencia 
    $consulta = "SELECT * FROM advertisers WHERE id = ?";

    if ($declaracion = mysqli_prepare($con, $consulta)) {
        //Vincular variables a la declaración
        mysqli_stmt_bind_param($declaracion, "i", $id_parametro);

        //Asignacion de parametros
        $id_parametro = trim($_GET["id"]);

        //Intento de ejecutar sentencia
        if (mysqli_stmt_execute($declaracion)) {
            $resultado = mysqli_stmt_get_result($declaracion);

            if (mysqli_num_rows($resultado) == 1) {
                $fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                //Recupera valor de cada campo
                $nombre = $fila["name"];
                $organizacion = $fila["organization"];
                $alias = $fila["alias"];
            } else {
                //La URL no contiene un parámetro de identificación válido. Redirigir a página de error
                echo "URL no contiene id valida";
                exit();
            }
        } else {
            echo "Error, Intentar mas tarde.";
        }
    }
    //Cerrar 
    mysqli_stmt_close($declaracion);

    //Cerrar conexion
    mysqli_close($con);
} else {
    //parametro id no encontrado
    echo "Parametro id no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Infinity-Anunciante Lectura</title>
        <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
        <?php include("../stylesheets.php"); ?>

    </head>
    <body>
        <?php
        if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
            if ($_SESSION['tipo'] == 1) {   //Si el usuario que accede tiene permisos, le mostramos el panel de usuario
                ?>
                <!-- 
                ----------------------------------------------------------------------
                Muestra por pantalla de la opción de vista extendida
                ----------------------------------------------------------------------
                -->
                <div class="envoltura">
                    <div class="container-fluid">
                        <div class="col-md-12">
                            <div class="page-header">
                                <h1>Vista de registro</h1>
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <p class="form-control-static"><?php echo $fila["name"]; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Organizacion</label>
                                <p class="form-control-static"><?php echo $fila["organization"]; ?></p>
                            </div>
                            <div class="form-group">
                                <label>Alias</label>
                                <p class="form-control-static"><?php echo $fila["alias"]; ?></p>
                            </div>
                            <p><a href="anunciante.php" class="btn btn-primary">Volver</a></p>
                        </div>                
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
            }
        } else {
            echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
        }
        ?>
    </body>
</html>
