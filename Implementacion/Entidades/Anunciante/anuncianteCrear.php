<?php
//Conexion
require_once "../../conexion.php";
 
//Definir e inicializar variables
$nombre = $organizacion = $alias = "";
$nombre_error = $organizacion_error = $alias_error = "";
 
//Procesar formulario recibido
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validacion de entradas
    $nombre_entrada = trim($_POST["nombre"]);
    if(empty($nombre_entrada)){
        $nombre_error = "Introduzca nombre.";
    } elseif(!filter_var($nombre_entrada, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nombre_error = "Nombre invalido";
    } else{
        $nombre = $nombre_entrada;
    }
    
    $organizacion_entrada = trim($_POST["organizacion"]);
    if(empty($organizacion_entrada)){
        $organizacion_error = "Introduzca la organizacion.";     
    } else{
        $organizacion = $organizacion_entrada;
    }
    
    $alias_entrada = trim($_POST["alias"]);
    if(empty($alias_entrada)){
        $alias_error = "Introduzca el alias.";     
    } else{
        $alias = $alias_entrada;
    }   
    // Chequear valores de entrada previamente a la insercion
    if(empty($nombre_error) && empty($organizacion_error) && empty($alias_error)){
        // Preparacion insercion
        $consulta = "INSERT INTO advertisers (name, organization, alias) VALUES (?, ?, ?)";
         
        if($declaracion = mysqli_prepare($con, $consulta)){
            //Enlazar parametros
            mysqli_stmt_bind_param($declaracion, "sss", $nombre_parametro, $organizacion_parametro, $alias_parametro);          
            // Asignacion de parametros
            $nombre_parametro = $nombre;
            $organizacion_parametro = $organizacion;
            $alias_parametro = $alias;          
            // Ejecucion de insercion
            if(mysqli_stmt_execute($declaracion)){
                // Si insercion correcta volver a gestion de anunciantes
                header("location: anunciante.php");
                exit();
            } else{
                echo "Error. Intentar más tarde.";
            }
        }       
        // Cerrar
        mysqli_stmt_close($declaracion);
    }   
    // Cerrar conexion con DB
    mysqli_close($con);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Record</title>
    <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
    <?php include("../stylesheets.php"); ?>
</head>
<body>
    <div class="envoltura">
        <div class="container-fluid">                
                    <div class="page-header">
                        <h2>Crear Anunciante</h2>
                    </div>
                    <form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div <?php echo (!empty($nombre_error)) ? 'Error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_error;?></span>
                        </div>
                        <div <?php echo (!empty($organizacion_error)) ? 'Error' : ''; ?>">
                            <label>Organizacion</label>
                            <input type="text" name="organizacion" class="form-control" value="<?php echo $organizacion; ?>">
                            <span class="help-block"><?php echo $organizacion_error;?></span>
                        </div>
                        <div <?php echo (!empty($alias_error)) ? 'Error' : ''; ?>">
                            <label>Alias</label>
                            <input type="text" name="alias" class="form-control" value="<?php echo $alias; ?>">
                            <span class="help-block"><?php echo $alias_error;?></span>
                        </div>
                        <input type="submit" class="btn btn-primary" value="Aceptar">
                        <a href="../../index.php" class="btn btn-default">Cancelar</a>
                    </form>                    
        </div>
    </div>
</body>
</html>