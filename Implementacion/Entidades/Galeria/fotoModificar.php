<?php

//======================================================================
//MODIFICACION DE UNA FOTO DE GRUPO
//======================================================================

//guardamos datos de la foto

$ImgId = $_POST['encabezado'];
$newEncabezado = $_POST['newEncabezado'];

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'encabezado' => FILTER_SANITIZE_STRING,
);

$saneado = filter_input_array(INPUT_POST, $saneamiento);
$encabezado = $saneado["encabezado"];

//-----------------------------------------------------
// Consulta a la base de datos
//-----------------------------------------------------
//Realizamos una conexion a la base de datos
include("../../conexion.php");


//actualizamos el encabezado
$consulta = "UPDATE `gallery` SET `encabezado` = '$newEncabezado' WHERE `gallery`.`id` = '$ImgId'";
$resultado = mysqli_query($con, $consulta);


mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta