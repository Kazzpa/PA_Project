<?php
//conexion
require_once "BackEnd/conexion";
 
//Definicion de variables vacias
$nombre = $organizacion = $alias = "";
$nombre_error = $organizacion_error = $alias_error = "";
 
//Procesamiento de datos del formulario una vez enviado
if(isset($_POST["id"]) && !empty($_POST["id"])){
    $id = $_POST["id"];
    
    //Validaciones
    $nombre_entrada = trim($_POST["nombre"]);
    if(empty($nombre_entrada)){
        $nombre_error = "Introduzca un nombre.";
    } elseif(!filter_var($nombre_entrada, FILTER_VALIDATE_REGEXP, array("options"=>array("regexp"=>"/^[a-zA-Z\s]+$/")))){
        $nombre_error = "Introduzca nombre valido.";
    } else{
        $nombre = $nombre_entrada;
    }
    
    $organizacion_entrada = trim($_POST["organizacion"]);
    if(empty($organizacion_entrada)){
        $organizacion_error = "Introduzca organizacion.";     
    } else{
        $organizacion = $organizacion_entrada;
    }
 
    $alias_entrada = trim($_POST["alias"]);
    if(empty($alias_entrada)){
        $alias_error = "Introduzca alias.";     
    }else{
        $alias = $alias_entrada;
    }
    
    //Chequea si hay errores en entradas antes de nada
    if(empty($nombre_error) && empty($organizacion_error) && empty($alias_error)){
        //Preparamos sentencia de actualizacion
        $sql = "UPDATE advertisers SET name=?, organization=?, alias=? WHERE id=?";
         
        if($stmt = mysqli_prepare($con, $sql)){
            //Vincula variables a declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "sssi", $nombre_parametro, $organizacion_parametro, $alias_parametro, $id_parametro);
            
            //Asignacion de parametros
            $nombre_parametro = $nombre;
            $organizacion_parametro = $organizacion;
            $alias_parametro = $alias;
            $id_parametro = $id;
            
            // Intenta ejecutar sentencia preparada
            if(mysqli_stmt_execute($stmt)){
                //Registros actualizados exitosamente
                header("location: anunciante.php");
                exit();
            } else{
                echo "Algo fue mal. Intentar mas tarde";
            }
        }       
        //Cerrar
        mysqli_stmt_close($stmt);
    }
    //Cerramos conexion
    mysqli_close($con);
} else{
    //Chequeamos que exista el parametro id
    if(isset($_GET["id"]) && !empty(trim($_GET["id"]))){
        // obtenemos parametro URL
        $id =  trim($_GET["id"]);
        
        //preparamos select
        $sql = "SELECT * FROM advertisers WHERE id = ?";
        if($stmt = mysqli_prepare($con, $sql)){
            //Vincula variables a declaracion preparada como parametros
            mysqli_stmt_bind_param($stmt, "i", $id_parametro);
            
            //asignamos parametro
            $id_parametro = $id;
            
            //Intenta ejecutar sentencia
            if(mysqli_stmt_execute($stmt)){
                $resultado = mysqli_stmt_get_result($stmt);
    
                if(mysqli_num_rows($resultado) == 1){
                    /*Obtener fila de resultados*/
                    $fila = mysqli_fetch_array($resultado, MYSQLI_ASSOC);
                    
                    //Recuperar valor
                    $nombre = $fila["name"];
                    $organizacion = $fila["organization"];
                    $alias = $fila["alias"];
                } else{
                    // URL no contiene id valida
                    echo "URL no contiene id valida";                
                    exit();
                }             
            } else{
                echo "Error, intentelo más tarde.";
            }
        }      
        //Cerrar
        mysqli_stmt_close($stmt);    
        //Cerrar conexion
        mysqli_close($con);
    }  else{
        // URL no contiene el parametro id
        echo "URL no contiene id valida";
        exit();
    }
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registro de Modificacion</title>
    <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
    <?php include("stylesheets.php"); ?>
</head>
<body>
    <div class="envoltura">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h2>Registro de Modificacion</h2>
                    </div>
                    <p>Edite valores de entrada y envie la informacion.</p>
                    <form action="<?php echo htmlspecialchars(basename($_SERVER['REQUEST_URI'])); ?>" method="post">
                        <div class="form-group <?php echo (!empty($nombre_error)) ? 'Error' : ''; ?>">
                            <label>Nombre</label>
                            <input type="text" name="nombre" class="form-control" value="<?php echo $nombre; ?>">
                            <span class="help-block"><?php echo $nombre_error;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($organizacion_error)) ? 'Error' : ''; ?>">
                            <label>Address</label>
                            <input type="text" name="organizacion" class="form-control" value="<?php echo $organizacion; ?>">
                            <span class="help-block"><?php echo $organizacion_error;?></span>
                        </div>
                        <div class="form-group <?php echo (!empty($alias_error)) ? 'Error' : ''; ?>">
                            <label>Salary</label>
                            <input type="text" name="alias" class="form-control" value="<?php echo $alias; ?>">
                            <span class="help-block"><?php echo $alias_error;?></span>
                        </div>
                        <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                        <input type="submit" class="btn btn-primary" value="Enviar">
                        <a href="anunciante.php" class="btn btn-default">Cancelar</a>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>