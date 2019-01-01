<?php

$username = $_POST['username'];

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
}

$consulta = "SELECT `rutaImagen` FROM `users` WHERE `username`= '$username'"; 

$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

$fila = mysqli_fetch_assoc($resultado);

$rutaImagen = $fila['rutaImagen'];

echo $rutaImagen;