<?php

session_start();

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'name' => FILTER_SANITIZE_STRING,
    'description' => FILTER_SANITIZE_STRING,
);

//Primero saneamos
$saneado = filter_input_array(INPUT_POST, $saneamiento); //saneado te devuelve un array asociativo clave valor con los campos del formulario

if (preg_match_all("/^[[:alnum:]]+", $saneado["name"]) == 0) {
    $errores[] = "Hay un error en el nombre del evento";
}
if (preg_match_all("/^[[:alnum:]]+$/", $saneado["descripcion"]) == 0) {
    $errores[] = "Hay un error en la descripcion";
}

if (isset($FILES["imagen"])) {
    if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
        $errores[] = "Hay un error con la imagen";
    } else {
        $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");

        if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
            if ($_FILES["imagen"]["size"] > 400 * 1024) {   //200 kb porque esta en bytes en principio
                $errores[] = "Hay un error con el size de imagen";
            } else {
                $nombreRuta = "eventPhotos/" . time() . $_FILES["imagen"]["name"];
                if (!file_exists("photos")) {
                    mkdir("userPhotos");
                }
                move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);
            }
        } else {
            $errores[] = "Hay un error con el tipo de imagen";
        }
    }
} else {
    $nombreRuta = "eventPhotos/default.png";
}
if (key_exists(0, $errores)) {  //Si hay algun error
    foreach ($errores as $clave => $valor) {
        echo "$valor <br/>";
    }
    echo "Le redireccionaremos a la creacion de evento en 3 segundos";
    header("Refresh: 3; URL = eventoCreacion.php");
} else {
    $name = $saneado["name"];
    $description = $saneado["description"];
    $date_celebration = $_POST["date-celebration"];
    $host = $_SESSION["username"];

    echo "$name $description $date_celebration $host";

    $con = mysqli_connect("localhost", "root", "", "infinity");

    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
    }

    $consulta = "INSERT INTO `events` (`id`, `name`, `description`, `date_creation`, `date_celebration`, `host`) VALUES (NULL, '$name', '$description', CURRENT_TIMESTAMP, '$date_celebration', '$host')";
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


