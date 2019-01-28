<?php

session_start();

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'nombre' => FILTER_SANITIZE_STRING,
    'password' => FILTER_SANITIZE_STRING,
    'username' => FILTER_SANITIZE_STRING,
    'email' => FILTER_SANITIZE_EMAIL,
);
//Primero saneamos
$saneado = filter_input_array(INPUT_POST, $saneamiento); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

$errores = array();
//A continuacion validamos
if (preg_match_all("/^[a-z ,.'-]+ [a-z ,.'-]+$/i", $saneado["nombre"]) == 0) {
    $errores[] = "Hay un error en el nombre";
}
if (preg_match_all("/^[[:alnum:]]+$/", $saneado["password"]) == 0) {
    $errores[] = "Hay un error en la password";
}
if (preg_match_all("/^[[:alnum:]]+$/", $saneado["username"]) == 0) {
    $errores[] = "Hay un error en el usuario";
}
if (preg_match_all("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/", $saneado["email"]) == 0) { //Validacion de email simple
    $errores[] = "Hay un error en el mail";
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
                $nombreRuta = "userPhotos/" . time() . $_FILES["imagen"]["name"];
                if (!file_exists("userPhotos")) {
                    mkdir("userPhotos");
                }
                move_uploaded_file($_FILES["imagen"]["tmp_name"], "../".$nombreRuta);
            }
        } else {
            $errores[] = "Hay un error con el formato de imagen";
        }
    }
} else {
    $nombreRuta = "userPhotos/default.png";
}

if (key_exists(0, $errores)) {  //Si hay algun error
    foreach ($errores as $clave => $valor) {
        echo "$valor <br/>";
    }
    echo "Le redireccionaremos al registro en 3 segundos";
    header("Refresh: 3; URL = cuentaRegistro.php");
} else {    //Si no hay errores seguimos procesando a la base de datos
    $nombre = $saneado['nombre']; //Rescatamos todas las variables del formulario y les hacemos un saneamiento
    $usuario = $saneado['username'];
    $password = $saneado['password'];
    $email = $saneado['email'];

    include("../../conexion.php");
    //Comprobamos si el usuario introducido ya existe, pues este va a hacer de pk en nuestra base de datos
    $consulta = "SELECT `username` FROM `users` WHERE `username`='$usuario'";
    $resultado = mysqli_query($con, $consulta);

    if (!(mysqli_num_rows($resultado) > 0)) {   //Si la consulta devuelve alguna fila es porque encontro alguna coincidencia
        $passwordHash = password_hash($password, PASSWORD_DEFAULT); //Encriptamos en la base de datos la contraseña para que nadie pueda verla
        //Hacemos una insercion en la base de datos, la fecha de registro es automatica
        $consulta = "INSERT INTO `users` (`username`, `name`, `password`, `email`, `date_register`, `tipo`, `rutaimagen`) VALUES ('$usuario', '$nombre', '$passwordHash', '$email', CURRENT_TIMESTAMP,'0', '$nombreRuta')";
        $resultado = mysqli_query($con, $consulta); //devuelve el resultado en caso de consulta, Verdadero en el resto de SQL si la ha realizado correctamente


        mysqli_close($con); // Cerramos la base de datos

        if ($resultado) {   //Comprobamos si la insercion ha sido un exito
            if (isset($_SESSION["rechazado"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
                unset($_SESSION["rechazado"]);
            }
            $_SESSION["exito"] = TRUE;
            header("Location: cuentaLogin.php");
            exit();
        } else {
            $_SESSION["rechazado"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver
            header("Location: cuentaRegistro.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
            exit();
        }
    } else {    //Si el nombre de usuario ya existe avisamos al usuario
        mysqli_close($con);
        $_SESSION["rechazado"] = TRUE;
        header("Location: cuentaRegistro.php");
        exit();
    }
}
    