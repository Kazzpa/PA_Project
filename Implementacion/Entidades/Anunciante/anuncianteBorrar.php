<?php 
session_start();
?>
<!--
//======================================================================
//BORRADO DE UN ANUNCIANTE
//======================================================================
-->
<?php
//Borrado
if (isset($_POST["id"]) && !empty($_POST["id"])) {
    //-----------------------------------------------------
    // Consulta a la base de datos
    //-----------------------------------------------------
    //Realizamos una conexion a la base de datos
    require_once "../../conexion.php";
    
    //Prepara sentencia sql de borrado
    $consulta = "DELETE FROM advertisers WHERE id = ?";
    if ($declaracion = mysqli_prepare($con, $consulta)) {
        //Enlace de variables
        mysqli_stmt_bind_param($declaracion, "i", $id_parametro);
        //Asignacion de parametros 
        $id_parametro = trim($_POST["id"]);
        // Ejecucion
        if (mysqli_stmt_execute($declaracion)) {
            //Borrado correcto
            header("location: anunciante.php");
            exit();
        } else {
            echo "Algo ha ido mal, intentar mas tarde.";
        }
    }
    //cerrar
    mysqli_stmt_close($declaracion);
    //Cerrar conexion
    mysqli_close($con);
} else {
    // Chequeamos que existe id 
    if (empty(trim($_GET["id"]))) {
        // URL sin id 
        echo "URL no contiene id valida";
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Infinity-Anunciante Borrar</title>
        <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
        <?php include("../stylesheets.php"); ?>
    </head>
    <body>
        <!-- 
        ----------------------------------------------------------------------
        Muestra por pantalla de la opción de borrado
        ----------------------------------------------------------------------
        -->
        <?php
        if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
            if ($_SESSION['tipo'] == 1) {   //Si el usuario que accede tiene permisos, le mostramos el panel de usuario
                ?>
                <div class = "envoltura">
                    <div class = "container-fluid">                  
                        <div class = "page-header">
                            <h1>Borrar registro</h1>
                        </div>
                        <!-- Pedimos una confirmación antes de borrar los datos presentando un formulario
                        , si se pulsa que sí se activa la petición de eliminación-->
                        <form action = " <?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> " method="post">
                            <div class="alert alert-danger fade in">
                                <input type = "hidden" name = "id" value = "<?php echo trim($_GET["id"]); ?>" />
                                <p>¿Estás seguro?</p>
                                <p>
                                    <input type = "submit" value = "Si" class = "btn btn-danger">
                                    <a href = "anunciante.php" class = "btn btn-default">No</a>
                                </p>
                            </div>
                        </form>                            
                    </div>
                </div>
                <?php
            } else {
                echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
            }
        } else {
            print_r($_SESSION);
            echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
        }
        ?>
    </body>
</html>