<?php

session_start();
//======================================================================
//DAMOS DE BAJA UNA RESERVA
//======================================================================
//-----------------------------------------------------
// Consulta a la base de datos
//-----------------------------------------------------
//Realizamos una conexion a la base de datos
include("../../conexion.php");

if (isset($_POST['user'])) {
    $usuario = $_POST['user'];
}
if (isset($_POST['event_id'])) {
    $evento = $_POST['event_id'];
}

//Eliminamos con una sentencia SQL la reserva de la tabla intermedia
$consulta = "DELETE FROM `reserva` WHERE `username` = '$usuario' AND `id_evento` = '$evento'"; //consulta SQL para obtener el usuario, luego comprobamos la password

$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
$paginaActual = $_SESSION['webRedirect'];

//Redireccionamos al usuario a la pagina en la que se encontraba
if ($resultado) {
    header("Location: $paginaActual?id=$evento");
    exit();
} else {
    header("Refresh: 3; URL = $paginaActual?id=$evento");
    echo "Hubo un error al dar de baja la reserva";
    exit();
}

