<?php

session_start();

$_SESSION['username'] = "irene";

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'msgTextArea' => FILTER_SANITIZE_STRING,
);
//Primero saneamos
$saneado = filter_input_array(INPUT_POST, $saneamiento); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

//aqui vendria la validacion pero en principio no hay que validar nada (se deja publicar lo que uno quiera)
//recogemos los datos
$message = $saneado['msgTextArea'];
$postedBy = $_SESSION['username'];
$eventId = 0;

$con = mysqli_connect("localhost", "root", "", "infinity");

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
}

$consulta = "INSERT INTO `posts` (`id`, `postedBy`, `eventId`, `postedDate`, `message`) VALUES ('NULL', '$postedBy', '$eventId', CURRENT_TIMESTAMP, '$message')";
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); // Cerramos la base de datos
if ($resultado) {   //Comprobamos si la insercion ha sido un exito
    if (isset($_SESSION["rechazado"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
        unset($_SESSION["rechazado"]);
    }
    $_SESSION["exito"] = TRUE;
} else {
    $_SESSION["rechazado"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver
}
header("Location: evento.php"); 
exit();

