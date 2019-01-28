<?php

//Limpiamos todas las variables de sesion al hacer logout
session_start(); //Hay que llamar a session_start en cada pagina php que vayamos a querer trabajar con algo relacionado con la session actual
session_unset();
session_destroy();
session_write_close();
setcookie(session_name(), '', 0, '/');
//session_regenerate_id(true);
/* El redireccionamiento tambien se podria hacer
  header("Location: login.php"); pero de esta forma no podemos enviar echo al usuario, se ejecuta directamente */
header('Refresh: 5; URL = ../../index.php'); /* El refresh son los segundos que tardara en redireccionarnos, una ventaja del refresh esque rompe el boton de back
  y no dejar volver hacia atras ya que regarga el contenido de la pagina */
echo 'Ha limpiado sesion si no le redirige el navegador pulsa <a href="../../index.php"> aqui <a>';
exit();
?>

