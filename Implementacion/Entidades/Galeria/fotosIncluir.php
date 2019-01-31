<?php
session_start();

//======================================================================
//ALTA DE LA IMAGEN DE UN GRUPO
//======================================================================

$filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'encabezado' => FILTER_SANITIZE_STRING);

$entradas = filter_input_array(INPUT_POST, $filtros);
$encabezado = trim($entradas["encabezado"]);
include_once ('../Grupo/grupo_db.php');
include_once ("../Logro/logros_admin.php");
$info = getGroup($_POST['grupoId']);
$idGrupo = $info[0];

if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
    if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
        $errores[] = "Hay un error con la imagen";
    } else {
        $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");

        if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
            $nombreRuta = "groupPhotos/" . $idGrupo . "/" . time() . $_FILES["imagen"]["name"];
            if (!file_exists("groupPhotos")) {
                mkdir("groupPhotos");
            }
            if (!file_exists("groupPhotos/" . $idGrupo)) {
                mkdir("groupPhotos/" . $idGrupo);
            }
            move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);
            include("../../conexion.php");
            $consulta = "INSERT INTO gallery ( id , grupo, rutaImagen, encabezado) VALUES ( 'NULL' , '" . $idGrupo . "' , '" . $nombreRuta . "' , '" . $encabezado . "')";
            $resultado = mysqli_query($con, $consulta);
            checkFotos($idGrupo);
            if (!$resultado) {
                $bol = false;
            }
            mysqli_close($con);
        } else {
            $errores[] = "Hay un error con el tipo de imagen";
        }
    }
} else {
    $nombreRuta = "groupPhotos/default.jpg";
}

header('Location: ../Grupo/grupo_mostrar.php'."?grupo=".$_POST['grupoId']);
?>