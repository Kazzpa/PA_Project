<?php

//session_start();
$post = $_POST['comment'];

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

$consulta = "DELETE FROM `posts` WHERE `posts`.`id` = '$post'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

