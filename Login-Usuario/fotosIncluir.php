<?php
include('conexion.php');
include 'functions.php';
    session_start();
    //Obtenemos el grupo seleccionado
    $idGrupo = 1;
    /*
    $bol = isset($_GET['grupo']) && $_GET['grupo'] != '';
    if ($bol) {
        $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                       'grupo' => FILTER_SANITIZE_STRING);
        $entradas = filter_input_array(INPUT_GET, $filtros);
        $info = getGroup($entradas['grupo']);
        $idGrupo = $info[0];
        //Grupo valido pero no registrado
        if(!$info){
            $bol = false;
        }
    }
    */
    $encabezado = trim($_POST["encabezado"]);
    if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
        if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
            $errores[] = "Hay un error con la imagen";
        }else{
            $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");
            
            if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
               /* if ($_FILES["imagen"]["size"] > 400 * 1024) {   //200 kb porque esta en bytes en principio
                    $errores[] = "Hay un error con el size de imagen";
                    echo  "Hay un error con el size de imagen";
                }else{*/
                    $nombreRuta = "groupPhotos/" . $idGrupo . "/" . time() . $_FILES["imagen"]["name"];
                    if (!file_exists("groupPhotos")) {
                        mkdir("groupPhotos");
                        mkdir("groupPhotos/" . $idGrupo);
                    }else{
                        if(!file_exists("groupPhotos/" . $idGrupo)){
                            mkdir("groupPhotos/" . $idGrupo);
                        }
                    }                   
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);
                    require_once "conexion.php";  
                    $consulta = "INSERT INTO gallery ( id , grupo, rutaImagen, encabezado) VALUES ( 'NULL' , '" . $idGrupo . "' , '" . $nombreRuta . "' , '" . $encabezado . "')"; 
                    $resultado = mysqli_query($con, $consulta);
                    /*echo "<br> consulta: <br/>" . $consulta . "<br/>";
                    if ($resultado) {
                        echo "exito";
                    }
                    if (!$resultado) {
                        $bol = false;
                    }*/
                    mysqli_close($con);                
                
            }else{
                $errores[] = "Hay un error con el tipo de imagen";
            }
        }
    } else {
        $nombreRuta = "groupPhotos/default.jpg";
    }
    header('Location: fotos.php');
?>