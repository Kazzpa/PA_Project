<?php

session_start();
//guardamos datos del evento actual
$_POST['eventId'] = 0;
$eventId = $_POST['eventId'];


$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

//seleccionamos los mensajes del evento
$consulta = "SELECT * FROM `posts` WHERE `eventId`='$eventId' ORDER BY `postedDate` DESC";
$resultado = mysqli_query($con, $consulta);
$fila = mysqli_fetch_all($resultado);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

//return
//Use JSON to transfer data types (arrays and objects) between client and server.
echo json_encode($fila);