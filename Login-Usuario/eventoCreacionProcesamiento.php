<?php

session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'nameEvent' => FILTER_SANITIZE_STRING,
    'description' => FILTER_SANITIZE_STRING,
    'grupoEvento' => FILTER_SANITIZE_NUMBER_INT,
);

//Primero saneamos
$saneado = filter_input_array(INPUT_POST, $saneamiento); //saneado te devuelve un array asociativo clave valor con los campos del formulario
$errores = array();

if (preg_match_all("/^[[:alnum:]]+/", $saneado["nameEvent"]) == 0) {
    $errores[] = "Hay un error en el nombre del evento";
}
if (preg_match_all("/^[[:alnum:]]+/", $saneado["description"]) == 0) {
    $errores[] = "Hay un error en la descripcion";
}
//Habria que integrarlo en vector errores
$errorGrupo = false;
if (!is_numeric($saneado['grupoEvento'])) {
    $errorGrupo = true;
    ;
}

$date_celebration = $_POST["date-celebration"];

if (preg_match_all("/(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2})/", $date_celebration) == 0) {
    $errores[] = "Hay un error en el formato de la fecha";
}

if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
    if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
        $errores[] = "Hay un error con la imagen";
    } else {
        $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");

        if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
            if ($_FILES["imagen"]["size"] > 400 * 1024) {   //200 kb porque esta en bytes en principio
                $errores[] = "Hay un error con el size de imagen";
            } else {
                $nombreRuta = "eventPhotos/" . time() . $_FILES["imagen"]["name"];
                if (!file_exists("eventPhotos")) {
                    mkdir("userPhotos");
                }
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);
            }
        } else {
            $errores[] = "Hay un error con el tipo de imagen";
        }
    }
} else {
    $nombreRuta = "eventPhotos/default.jpg";
}
if (key_exists(0, $errores)) {  //Si hay algun error
    foreach ($errores as $clave => $valor) {
        echo "$valor <br/>";
    }
    echo "Le redireccionaremos a la creacion de evento en 3 segundos";
    header("Refresh: 3; URL = eventoCreacion.php");
} else {
    //primero insertamos la localizacion del evento
    include("localizacionProcesamiento.php");

    $name = $saneado["nameEvent"];
    $description = $saneado["description"];
    $host = $_SESSION["username"];
    $grupo = 0;
    if (!$errorGrupo) {
        $grupo = $saneado["grupoEvento"];
    }
    include("conexion.php");

    $consulta = "INSERT INTO `events` (`id`, `name`, `description`, "
            . "`date_creation`, `date_celebration`, `host`, `rutaimagen`, "
            . "`idLocation`, `idAdvertisers`, `group_id` ) VALUES "
            . "(NULL, '$name', '$description', CURRENT_TIMESTAMP, "
            . "'$date_celebration', '$host' , '$nombreRuta', '$idLocalizacion', '0', '$grupo')";
    $resultado = mysqli_query($con, $consulta); //devuelve el resultado en caso de consulta, Verdadero en el resto de SQL si la ha realizado correctamente

    mysqli_close($con); // Cerramos la base de datos

    if ($resultado) {   //Comprobamos si la insercion ha sido un exito
        if (isset($_SESSION["rechazado"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
            unset($_SESSION["rechazado"]);
        }
        $_SESSION["exito"] = TRUE;
        header("Location: index.php");
        exit();
    } else {
        $_SESSION["rechazado"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver
        header("Location: eventoCreacion.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
        exit();
    }
}


