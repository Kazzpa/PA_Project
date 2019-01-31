<?php

//======================================================================
//ELIMINACION DE MENSAJE
//======================================================================
//Obtenemos el id del mensaje a eliminar
$post = $_POST['comment'];

//-----------------------------------------------------
// Consulta a la base de datos
//-----------------------------------------------------
//Realizamos una conexion a la base de datos
include("../../conexion.php");

//Sentencia para la eliminacion de un mensaje a traves del id
$consulta = "DELETE FROM `posts` WHERE `posts`.`id` = '$post'";
$resultado = mysqli_query($con, $consulta);

//Cerramos la conexion a la base de datos ya que no nos hace falta
mysqli_close($con);

