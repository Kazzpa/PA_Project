<?php

session_start();

if (isset($_POST["modificarFoto"])) {
    if (isset($_FILES["imagen"])) {
        if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
            echo "Hay un error con la imagen";
            redireccionLogin();
        } else {
            $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");

            if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
                if ($_FILES["imagen"]["size"] > 400 * 1024) {   //200 kb porque esta en bytes en principio
                    echo "Hay un error con el size de imagen";
                    redireccionLogin();
                } else {
                    $nombreRuta = "eventPhotos/" . time() . $_FILES["imagen"]["name"];
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);

                    include("../../conexion.php");
                    //Evento al que hay que modificar la foto
                    $id = $_POST["selectEvento"];

                    $username = $_SESSION["username"];
                    //Obtenemos la ruta antigua para eliminarla
                    $consulta = "SELECT rutaimagen FROM `events` WHERE id = '$id'"; //consulta SQL para obtener el usuario, luego comprobamos la password
                    $resultado = mysqli_query($con, $consulta);
                    $rutaAntigua = mysqli_fetch_assoc($resultado);
                    $rutaAntigua = $rutaAntigua["rutaimagen"];

                    //Cambiamos la imagen de usuario
                    $consulta = "UPDATE `events` SET `rutaimagen` = '$nombreRuta' WHERE `events`.`id` = $id"; //consulta SQL para obtener el usuario, luego comprobamos la password
                    $resultado = mysqli_query($con, $consulta);

                    mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

                    if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                        //Si se actualizo correctamente borramos la anterior
                        if ($rutaAntigua != "eventPhotos/default.jpg")
                            unlink($rutaAntigua);
                        echo "Se hizo el cambio de imagen correctamente";
                        redireccionLogin();
                        exit();
                    } else {
                        echo "Algo salio mal al intentar modificar el campo seleccionado";
                        redireccionLogin();
                        exit();
                    }
                }
            } else {
                echo "Hay un error con el tipo de imagen";
                header("Refresh: 3; URL = ../Usuario/cuentaLogin.php");
            }
        }
    } else {
        echo "No ha introducido ninguna imagen, le redireccionaremos ";
        redireccionLogin();
        exit();
    }
} else if (isset($_POST["botonEventoModificar"])) {
    $saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'campoTexto' => FILTER_SANITIZE_STRING,
    );

    $saneado = filter_input_array(INPUT_POST, $saneamiento);

    $id = $_POST["selectEvento"];
    $value = $saneado["campoTexto"];
    $opcion = $_POST["selectCampoEventoModificar"];

    $host = $_SESSION["username"];

    include("../../conexion.php");

    $consulta = "UPDATE `events` SET `$opcion` = '$value' WHERE `events`.`id` = '$id'"; //consulta SQL para obtener el usuario, luego comprobamos la password
    $resultado = mysqli_query($con, $consulta);

    mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

    if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
        redireccionLogin();
        echo "Se ha actualizado el campo correctamente!";
        exit();
    } else {
        echo "Algo salio mal al intentar modificar el campo seleccionado";
        redireccionLogin();
        exit();
    }
}
//redireccionamos a cuentaLogin.php
function redireccionLogin(){
    header("Refresh: 5; URL = ../Usuario/cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
}
