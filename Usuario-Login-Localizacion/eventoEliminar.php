<?php

session_start();

$evento_id = $_POST['selectEventoEliminar'];    //Obtenemos el evento seleccionado

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
}

$consulta = "DELETE FROM `events` WHERE `id` = '$evento_id'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado   
    header('Refresh: 1; URL = cuentaLogin.php');
    echo "Se elimino el evento seleccionado, esperamos que cree otro pronto";
    exit();
} else {
    echo "Algo salio mal al intentar borrar el evento";
    header("Refresh: 5; URL = cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}
