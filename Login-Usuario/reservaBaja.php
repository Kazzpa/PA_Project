<?php

session_start();
include_once("conexion.php");

if (isset($_POST['user'])) {
    $usuario = $_POST['user'];
}
if (isset($_POST['event_id'])) {
    $evento = $_POST['event_id'];
}

include_once("conexion.php");
$consulta = "DELETE FROM `reserva` WHERE `username` = '$usuario' AND `id_evento` = '$evento'"; //consulta SQL para obtener el usuario, luego comprobamos la password

$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
$paginaActual = $_SESSION['webRedirect'];

if ($resultado) {
    header("Location: $paginaActual?id=$evento");
    exit();
} else {
    header("Refresh: 3; URL = $paginaActual?id=$evento");
    echo "Hubo un error al dar de baja la reserva";
    exit();
}

