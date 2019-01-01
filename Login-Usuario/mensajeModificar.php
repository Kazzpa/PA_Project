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

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}


//seleccionamos los mensajes del evento
$consulta = "UPDATE `posts` SET `message` = '$newMessage' WHERE `posts`.`id` = '$postId'";
$resultado = mysqli_query($con, $consulta);


mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta