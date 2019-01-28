<?php

session_start();
include '../Logro/logros_admin.php';
$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'msgTextArea' => FILTER_SANITIZE_STRING,
);
//Primero saneamos
$saneado = filter_input_array(INPUT_POST, $saneamiento); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

//aqui vendria la validacion pero en principio no hay que validar nada (se deja publicar lo que uno quiera)
//recogemos los datos
$message = $saneado['msgTextArea'];
$postedBy = $_SESSION['username'];
$eventId = $_GET['id'];

include("../../conexion.php");

$consulta = "INSERT INTO `posts` (`id`, `idReply`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES ('NULL', '0', '$postedBy', '$eventId', CURRENT_TIMESTAMP, '$message')";
$resultado = mysqli_query($con, $consulta);

$sql = "SELECT events.group_id FROM events, posts WHERE "
        . "posts.eventId = '$eventId' AND posts.eventId = events.id";
$res = mysqli_query($link, $sql);
$ret = false;
if ($arr = mysqli_fetch_array($res)) {
    $ret = $arr['total'];
}
checkComentarios($ret);
mysqli_close($con); // Cerramos la base de datos

header("Location: ../Evento/eventoMostrar.php?id=$eventId");
exit();

