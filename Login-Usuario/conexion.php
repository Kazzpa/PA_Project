<?php

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}