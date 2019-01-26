<?php
//Chequea que exista parametro id
if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
    require_once "BackEnd/conexion.php";
    
    //Preparacion sentencia 
    $sql = "SELECT * FROM advertisers WHERE id = ?";
    
    if($stmt = mysqli_prepare($con, $sql)){
        //Vincular variables a la declaración
        mysqli_stmt_bind_param($stmt, "i", $id_parametro);
        
        //Asignacion de parametros
        $id_parametro = trim($_GET["id"]);
        
        //Intento de ejecutar sentencia
        if(mysqli_stmt_execute($stmt)){
            $resultado = mysqli_stmt_get_result($stmt);
    
            if(mysqli_num_rows($resultado) == 1){                
                $fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC);             
                //Recupera valor de cada campo
                $nombre = $fila["name"];
                $organizacion = $fila["organization"];
                $alias = $fila["alias"];
            } else{
                //La URL no contiene un parámetro de identificación válido. Redirigir a página de error
                echo "URL no contiene id valida";
                exit();
            }           
        } else{
            echo "Error, Intentar mas tarde.";
        }
    }   
    //Cerrar 
    mysqli_stmt_close($stmt);
    
    //Cerrar conexion
    mysqli_close($con);
} else{
    //parametro id no encontrado
    echo "Parametro id no encontrado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vista de Registro</title>
    <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
    <?php include("stylesheets.php"); ?>
    
</head>
<body>
    <div class="envoltura">
        <div class="container-fluid">
            <div class="row">
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
    </div>
</body>
</html>
