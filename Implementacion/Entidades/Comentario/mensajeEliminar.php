<?php

$post = $_POST['comment'];

include("../../conexion.php");

$consulta = "DELETE FROM `posts` WHERE `posts`.`id` = '$post'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

