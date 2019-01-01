<?php

session_start();

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

$con = mysqli_connect("localhost", "root", "", "infinity");

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
}

$consulta = "INSERT INTO `posts` (`id`, `idReply`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES ('NULL', '0', '$postedBy', '$eventId', CURRENT_TIMESTAMP, '$message')";
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); // Cerramos la base de datos

header("Location: eventoMostrar.php?id=$eventId"); 
exit();

