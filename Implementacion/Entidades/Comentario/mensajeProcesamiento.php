<?php
session_start();

//======================================================================
//PROCESAMIENTO DE MENSAJES
//======================================================================
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

//-----------------------------------------------------
// Consulta a la base de datos
//-----------------------------------------------------
//Realizamos una conexion a la base de datos
include("../../conexion.php");

//Realizamos la insercion del mensaje en la Base de Datos con todos los atributos correspondientes
$consulta = "INSERT INTO `posts` (`id`, `idReply`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES ('NULL', '0', '$postedBy', '$eventId', CURRENT_TIMESTAMP, '$message')";
$resultado = mysqli_query($con, $consulta);
$idPost = mysqli_insert_id($con);
$sql = "SELECT events.group_id as total FROM events, posts WHERE "
        . "posts.id = '$idPost' AND posts.eventId = events.id";
$res = mysqli_query($con, $sql);
$ret = false;
if ($arr = mysqli_fetch_array($res)) {
    $ret = $arr['total'];
    if ($ret != 0) {
        checkComentarios($ret);
    }
}
mysqli_close($con); // Cerramos la base de datos

header("Location: ../Evento/eventoMostrar.php?id=$eventId");
exit();

