<?php

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 
mysqli_set_charset($con, "utf8");
$con_error = false;
if (!$con) {
    $con_error = true;
    //die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

//$con = mysqli_connect("fdb24.awardspace.net", "2932955_infinity", "Infinity.123", "2932955_infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

//if (!$con) {
//    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
//}