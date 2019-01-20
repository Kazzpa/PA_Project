<?php

$foto = $_POST['foto'];

include("conexion.php");

$consultaRuta = "SELECT `rutaImagen` FROM `gallery` WHERE `gallery`.`id` = '$foto'";
$resultadoRuta = mysqli_query($con, $consultaRuta);
$rutaFoto = mysqli_fetch_assoc($resultadoRuta);

$consulta = "DELETE FROM `gallery` WHERE `gallery`.`id` = '$foto'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado)
    unlink($rutaFoto['rutaImagen']);

