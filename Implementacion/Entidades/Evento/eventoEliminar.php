<?php

session_start();

$evento_id = $_POST['selectEvento'];    //Obtenemos el evento seleccionado
include("../../conexion.php");

//-----------------------------------------------------
// Llamada a eliminar la localizacion
//-----------------------------------------------------
include("../Localizacion/localizacionEliminar.php");

//-----------------------------------------------------
// Eliminar evento
//-----------------------------------------------------
$consulta = "DELETE FROM `events` WHERE `id` = '$evento_id'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado   
    header('Refresh: 1; URL = ../Usuario/cuentaLogin.php');
    echo "Se elimino el evento seleccionado, esperamos que cree otro pronto";
    exit();
} else {
    echo "Algo salio mal al intentar borrar el evento";
    header("Refresh: 5; URL = ../Usuario/cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}
