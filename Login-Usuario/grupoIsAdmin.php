<?php

//guardamos datos del grupo actual

$info = getGroup($entradas['grupo']);
$grupoId = $info[0];

$user = $_SESSION['username'];
//$grupoId = "hack and beers";
//$user = "irene";
//echo "Grupo Id: ".$grupoId." Usuario: ".$user;

include("conexion.php");

//seleccionamos los mensajes del evento
$consulta = "SELECT `grupo_id`,`rol` FROM `suscripcion_grupo` WHERE `user_id`='$user'";
$resultado = mysqli_query($con, $consulta);
$fila = mysqli_fetch_assoc($resultado);

if(strtolower($fila['grupo_id']) == $grupoId && $fila['rol'] == 1){
    $admin = true;
} else{
    $admin = false;
}

mysqli_close($con);
