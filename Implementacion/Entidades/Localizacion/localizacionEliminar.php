<?php

/*
 * Eliminacion de una localización: 
 * Comprobamos si la localizacion del evento a eliminar tiene mas de un evento asociado
 */


// Para ello primero obtenemos la id de la localizacion del evento que se quiere modificar
$query = "SELECT `idLocation` FROM `events` WHERE `id` =" . $evento_id;
$result = mysqli_query($con, $query);
$row = mysqli_fetch_assoc($result);

$idLocalizacion = $row['idLocation'];
//Comprobamos si existe mas de un evento con esa idLocation en eventos
$evento = "SELECT `id` FROM `events` WHERE `idLocation`='$idLocalizacion'";
$resultado_evento = mysqli_query($con, $evento);

if (mysqli_num_rows($resultado_evento) < 2) { //si la consulta devuelve menos de 2 valores es porque solo está registrado 1 vez
    //En cuyo caso se eliminaria localizacion de la bd
    $eliminacion = "DELETE FROM `locations` WHERE `id` = '$idLocalizacion'";
    $resultado_eliminacion = mysqli_query($con, $eliminacion);
} 