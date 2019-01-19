<?php

$rutaImg = "img/";

//Comprobar que tenga acceso
//chequear http://php.net/manual/en/function.mysql-real-escape-string.php
//logroname  logrodesc logroicon logrotipo logrovalor logropuntos
//crea la conexion con la base de datos y no la cierra.
function conectarDB() {
    include_once("conexion.php");
    if ($con_error) {
        return false;
    }
    return $con;
}

function crearLogro($name, $icon, $desc, $tipo, $valor, $puntos) {
    $link = conectarDB();
    $bol = false;
    if ($link !== false) {
        $name = mysqli_real_escape_string($link, $name);
        $icon = mysqli_real_escape_string($link, $icon['name']);
        $desc = mysqli_real_escape_string($link, $desc);
        //Hacemos una insercion en la base de datos, la fecha de registro es automatica
        $consulta = "INSERT INTO logro ( id , name, icon_path, descripcion, tipo, valor, puntos)"
                . " VALUES ( 'NULL' , '" . $name . "' , '" . $GLOBALS['rutaImg'] 
                . $icon . "' , '" . $desc . "', '" . $tipo . "', '" . $valor 
                . "', '" . $puntos . "'  )";
        $resultado = mysqli_query($link, $consulta);
        if ($resultado) {
            $bol = true;
        }
        mysqli_close($link);
    }
    return $bol;
}
