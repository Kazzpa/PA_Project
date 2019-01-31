<?php

//======================================================================
//ELIMINACION DE UNA IMAGEN CONCRETA DE UN GRUPO
//======================================================================

$foto = $_POST['foto'];

//-----------------------------------------------------
// Consulta a la base de datos
//-----------------------------------------------------
//Realizamos una conexion a la base de datos
include("../../conexion.php");

//Sentencia SQL para obtener la ruta de la imagen que vamos a borrar
$consultaRuta = "SELECT `rutaImagen` FROM `gallery` WHERE `gallery`.`id` = '$foto'";
$resultadoRuta = mysqli_query($con, $consultaRuta);
$rutaFoto = mysqli_fetch_assoc($resultadoRuta);

//Borrado de la imagen
$consulta = "DELETE FROM `gallery` WHERE `gallery`.`id` = '$foto'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado)
    unlink($rutaFoto['rutaImagen']);

