<?php

session_start();

if (isset($_POST["modificarFoto"])) {   //Si hemos pulsado el boton de modificar foto
    if (isset($_FILES["imagen"]) && !empty($_FILES['imagen']['tmp_name'])) {
        if ($_FILES["imagen"]["error"] > 0) {   //Comprobamos que la imagen pasa los parametros
            echo "Hay un error con la imagen";
            header("Refresh: 3; URL = cuentaLogin.php");
        } else {
            $tiposAceptados = array("image/jpg", "image/jpeg", "image/png");

            if (array_search($_FILES["imagen"]["type"], $tiposAceptados)) {
                if ($_FILES["imagen"]["size"] > 400 * 1024) {   //200 kb porque esta en bytes en principio
                    echo "Hay un error con el size de imagen";
                    header("Refresh: 3; URL = cuentaLogin.php");
                } else {
                    $nombreRuta = "userPhotos/" . time() . $_FILES["imagen"]["name"];
                    move_uploaded_file($_FILES["imagen"]["tmp_name"], $nombreRuta);

                    include("../../conexion.php");
                    $username = $_SESSION["username"];
                    //Obtenemos la ruta antigua para eliminarla
                    $consulta = "SELECT rutaimagen FROM `users` WHERE username = '$username'"; //consulta SQL para obtener el usuario, luego comprobamos la password
                    $resultado = mysqli_query($con, $consulta);
                    $rutaAntigua = mysqli_fetch_assoc($resultado);
                    $rutaAntigua = $rutaAntigua["rutaimagen"];

                    //Cambiamos la imagen de usuario
                    $consulta = "UPDATE `users` SET `rutaimagen` = '$nombreRuta' WHERE `users`.`username` = '$username'"; //consulta SQL para obtener el usuario, luego comprobamos la password
                    $resultado = mysqli_query($con, $consulta);

                    mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

                    if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                        //Si se actualizo correctamente borramos la anterior
                        if ($rutaAntigua != "userPhotos/default.png")
                            unlink($rutaAntigua);
                        $_SESSION["rutaimagen"] = $nombreRuta;
                        echo "Se hizo el cambio de imagen correctamente";
                        header('Refresh: 3; URL = cuentaLogin.php');
                        exit();
                    } else {
                        echo "Algo salio mal al intentar modificar el campo seleccionado";
                        header("Refresh: 3; URL = cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
                        exit();
                    }
                }
            } else {
                echo "Hay un error con el tipo de imagen";
                header("Refresh: 3; URL = cuentaLogin.php");
            }
        }
    } else {
        echo "No ha introducido ninguna imagen, le redireccionaremos ";
        header("Refresh: 3; URL = cuentaLogin.php");
        exit();
    }
} else if (isset($_POST["modificarDato"])) { //Si queremos modificar otro campo
    $saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'campoTexto' => FILTER_SANITIZE_STRING,
    );

    $saneado = filter_input_array(INPUT_POST, $saneamiento);
    $value = $saneado["campoTexto"];
    $opcion = $_POST["selectCuentaModificar"];

    $errores = array();
//A continuacion validamos
    if ((preg_match_all("/^[[:alnum:]]+$/", $value) == 0) && $opcion == "password") {
        $errores[] = "Hay un error en el nombre";
    }
    if ((preg_match_all("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $value) == 0) && $opcion == "email") {
        $errores[] = "Hay un error con el correo electronico";
    }

    if (key_exists(0, $errores)) {  //Si hay algun error en la validacion
        foreach ($errores as $clave => $valor) {
            echo "$valor <br/>";
        }
        header('Refresh: 3; URL = cuentaRegistro.php');
        echo "Le redireccionaremos al registro en 3 segundos";
    } else {
        $username = $_SESSION["username"];

        include("../../conexion.php");

        if ($opcion == "password") {
            $value = password_hash($value, PASSWORD_DEFAULT);
        }

        $consulta = "UPDATE `users` SET `$opcion` = '$value' WHERE `users`.`username` = '$username'"; //consulta SQL para obtener el usuario, luego comprobamos la password
        $resultado = mysqli_query($con, $consulta);

        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

        if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
            header('Refresh: 1; URL = cuentaLogout.php');
            echo "Se ha actualizado el campo correctamente, debera loguearse de nuevo!";
            exit();
        } else {
            echo "Algo salio mal al intentar modificar el campo seleccionado";
            header("Refresh: 5; URL = ../../index.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
            exit();
        }
    }
}

