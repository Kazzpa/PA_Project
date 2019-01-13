<?php

session_start();

$usuario = $_SESSION['username'];

include_once("conexion.php");

$consulta = "DELETE FROM `users` WHERE username = '$usuario'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado   
    header('Refresh: 1; URL = cuentaLogout.php');
    echo "Estamos muy tristes de que haya decidido irse. Estaremos aqui esperandole!";
    exit();
} else {
    echo "Algo salio mal al intentar borrar la cuenta";
    header("Refresh: 5; URL = index.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}