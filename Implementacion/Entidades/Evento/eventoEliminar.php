<?php

session_start();

$evento_id = $_POST['selectEvento'];    //Obtenemos el evento seleccionado
include("../../conexion.php");

//Comprobamos si la localizacion del evento a eliminar tiene mas de un evento asociado
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
