<?php

session_start();
include_once("conexion.php");

if (isset($_POST['user'])) {
    $usuario = $_POST['user'];
}
if (isset($_POST['event_id'])) {
    $evento = $_POST['event_id'];
}

include_once("conexion.php");
$consulta = "INSERT INTO `reserva` (`id`, `username`, `id_evento`) VALUES (NULL, '$usuario', '$evento')"; //consulta SQL para obtener el usuario, luego comprobamos la password

$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
$paginaActual = $_SESSION['webRedirect'];

if ($resultado) {
    $from = "no-reply@infinity-events.dx.am";
    $to = $_SESSION["email"];
    $subject = "Recordatorio de tu reserva en Infinity";

// mensaje
    $message = "
<html>
<head>
  <title>Recordatorio de tu reserva en Infinity</title>
</head>
<body>
  <p>¡Gracias por reservar plaza para un evento!</p><br />
  <p>A continuacion te dejamos un QR code por si quieres compartir este evento con tus amigos. Recuerda que si quieres darte de baja del evento
  solo tienes que hacerlo desde el mismo sitio donde te apuntaste</p> <br/>
  <img src='https://chart.googleapis.com/chart?cht=qr&chl=http://infinity-events.dx.am/$paginaActual?id=$evento&chs=160x160&chld=L|0' alt='Logo' title='Logo' style='display:block' width='300' height='300'> </img><br />
<p>Muchas gracias por confiar en Infinity, de parte de todo nuestro equipo esperamos que sigas usando nuestro servicio</p>
</body>
</html>
";

// Para enviar un correo HTML, debe establecerse la cabecera Content-type
    $headers = "From: Infinity no-reply@infinity-events.dx.am" . "\r\n" ;
    $headers .="Reply-To: no-reply@infinity-events.dx.am\r\n" ;
    $headers .="X-Mailer: PHP/" . phpversion();
    $headers .="Date: ".date("r")."\r\n";
    $headers .= "MIME-Version: 1.0\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
    mail($to, $subject, $message, $headers);

// Enviarlo
    header("Refresh: 3; URL = $paginaActual?id=$evento");
    echo "Se ha enviado un QR por si quiere compartir el evento";
    exit();
} else {
    header("Refresh: 3; URL = $paginaActual?id=$evento");
    echo "Hubo un error al dar de alta la reserva";
    exit();
}