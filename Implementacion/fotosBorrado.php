<?php
//Borrado
if(isset($_POST["id"]) && !empty($_POST["id"])){
    require_once "BackEnd/conexion.php";  
    //Prepara sentencia sql de borrado
    $sql = "DELETE FROM gallery WHERE id = ?";   
    if($stmt = mysqli_prepare($con, $sql)){
        //Enlace de variables
        mysqli_stmt_bind_param($stmt, "i", $id_parametro);      
        //Asignacion de parametros 
        $id_parametro = trim($_POST["id"]);      
        // Ejecucion
        if(mysqli_stmt_execute($stmt)){
            //Borrado correcto
            header("location: fotos.php");
            exit();
        } else{
            echo "Algo ha ido mal, intentar mas tarde.";
        }
    }     
    //cerrar
    mysqli_stmt_close($stmt);    
    //Cerrar conexion
    mysqli_close($con);
} else{
    // Chequeamos que existe id 
    if(empty(trim($_GET["id"]))){
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
    <title>Ver registro</title>
    <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
    <?php include("stylesheets.php"); ?>
</head>
<body>
    <div class="envoltura">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header">
                        <h1>Borrar registro</h1>
                    </div>
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="alert alert-danger fade in">
                            <input type="hidden" name="id" value="<?php echo trim($_GET["id"]); ?>"/>
                            <p>¿Estás seguro?</p><br>
                            <p>
                                <input type="submit" value="Si" class="btn btn-danger">
                                <a href="fotos.php" class="btn btn-default">No</a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>