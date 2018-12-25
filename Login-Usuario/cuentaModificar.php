<?php

session_start();

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'campoTexto' => FILTER_SANITIZE_STRING,
);

$saneado = filter_input_array(INPUT_POST, $saneamiento);
$value = $saneado["campoTexto"];
$opcion = $_POST["select"];

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
    echo "Le redireccionaremos al registro en 3 segundos";
} else {
    $username = $_SESSION["username"];

    $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia

    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
    }

    if ($value == "password") {
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
        header("Refresh: 5; URL = index.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
        exit();
    }
}

