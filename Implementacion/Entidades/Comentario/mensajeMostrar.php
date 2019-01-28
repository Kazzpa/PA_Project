<?php

//session_start();
//guardamos datos del evento actual
$eventId = $_GET['id'];


include("../../conexion.php");

//seleccionamos los mensajes del evento
$consulta_posts = "SELECT * FROM `posts` WHERE `eventId`='$eventId' ORDER BY `postedDate` DESC";
$resultado_posts = mysqli_query($con, $consulta_posts);
$username = array();
$posts = array();
while($fila_posts = mysqli_fetch_assoc($resultado_posts)){
    //Recogemos todos los nombres de usuario
    array_push($username, $fila_posts['postedBy']);
    //tambien los datos de los comentarios
    array_push($posts, $fila_posts);
}

//eliminamos valores duplicados del array
$username = array_unique($username);

//preparamos el formato del IN del statement
$in = '("' . implode('","', $username) . '")';

$consulta_imagen = "SELECT `username`,`rutaImagen` FROM `users` WHERE `username` IN " . $in;
$resultado_imagen = mysqli_query($con, $consulta_imagen) or die("Error en la consulta " + $consulta_imagen);


while($fila_imagen = mysqli_fetch_assoc($resultado_imagen)){
    //damos un formato a como aparecen las imagenes: será del tipo username => imagen.jpg
    $fila_imagen_format[$fila_imagen['username']] = $fila_imagen['rutaImagen'];
}

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta



$data = ['posts' => $posts, 'imagenes' => $fila_imagen_format];
//return
//Use JSON to transfer data types (arrays and objects) between client and server.
echo json_encode($data);