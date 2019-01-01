<?php

//session_start();
//guardamos datos del evento actual
$eventId = $_GET['id'];

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

//seleccionamos los mensajes del evento
$consulta_posts = "SELECT * FROM `posts` WHERE `eventId`='$eventId' ORDER BY `postedDate` DESC";
$resultado_posts = mysqli_query($con, $consulta_posts);
$fila_posts = mysqli_fetch_all($resultado_posts);

//Recogemos todos los nombres de usuario
$username = array();
for ($i = 0; $i < sizeof($fila_posts); $i++) {
    array_push($username, $fila_posts[$i][2]);
}

//eliminamos valores duplicados del array
$username = array_unique($username);

//preparamos el formato del IN del statement
$in = '("' . implode('","', $username) . '")';

$consulta_imagen = "SELECT `username`,`rutaImagen` FROM `users` WHERE `username` IN " . $in;
//echo $consulta_imagen;
$resultado_imagen = mysqli_query($con, $consulta_imagen) or die("Error en la consulta " + $consulta_imagen);
$fila_imagen = mysqli_fetch_all($resultado_imagen);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

//damos un formato a como aparecen las imagenes: será del tipo username => imagen.jpg
for($i=0;$i<sizeof($fila_imagen);$i++){
    $fila_imagen_format[$fila_imagen[$i][0]] = $fila_imagen[$i][1];
}

$data = ['posts' => $fila_posts, 'imagenes' => $fila_imagen_format];
//return
//Use JSON to transfer data types (arrays and objects) between client and server.
echo json_encode($data);