<?php

//session_start();
//guardamos datos del comentario
$postId = $_POST['comment'];
$newMessage = $_POST['newComment'];


$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'newComment' => FILTER_SANITIZE_STRING,
);

$saneado = filter_input_array(INPUT_POST, $saneamiento);
$newMessage = $saneado["newComment"];

include_once("conexion.php");


//seleccionamos los mensajes del evento
$consulta = "UPDATE `posts` SET `message` = '$newMessage' WHERE `posts`.`id` = '$postId'";
$resultado = mysqli_query($con, $consulta);


mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta