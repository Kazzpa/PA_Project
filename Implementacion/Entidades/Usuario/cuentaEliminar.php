<?php

session_start();
//======================================================================
// OPERACION ELIMINACION USUARIO
//======================================================================
//Realizamos la conexion a la base de datos
include("../../conexion.php");

//Obtenemos la variable de sesion de usuario para realizar la consulta de eliminacion
$usuario = $_SESSION['username'];
$consulta = "DELETE FROM `users` WHERE username = '$usuario'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

//Cerramos la base de datos
mysqli_close($con);

//Si la consulta ha tenido exito redireccionamos al usuario y mostramos un mensaje por pantalla del exito
if ($resultado) {
    header('Refresh: 1; URL = ../Usuario/cuentaLogout.php');
    echo "Estamos muy tristes de que hayas decidido irte ¡Estaremos aqui esperándote!";
    exit();
} else {    //Si la consulta fracasa redireccionamos al usuario e informamos del error
    header("Refresh: 5; URL = ../../index.php");
    echo "Algo salio mal al intentar borrar la cuenta";
    exit();
}