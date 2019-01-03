<?php

//crea la conexion con la base de datos y no la cierra.
function connectDB() {
    $con = mysqli_connect("localhost", "root", "");
    if (!$con) {
        die("ERROR: Can't connect to host");
    }
    $db = mysqli_select_db($con, "infinity");
    if (!$db) {
        die("ERROR: Can't connect to DB ");
    }
    return $con;
}
//Devuelve un array con la informacion del grupo si existe, y si no falso
// 0: ID    1:name  2:descripcion   3:rutaImagen
function getGroup($getName) {
    $link = connectDB();
    $sql = "SELECT * FROM grupo WHERE name = '" . $getName . "'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        die("ERROR: SELECT QUERY ERROR");
    } else {
        if ($row = mysqli_fetch_array($res)) {
            $i = 0;
            while ($i < 4) {
                $ret[] = $row[$i];
                $i++;
            }
        }
        mysqli_close($link);
    }
    return $ret;
}
function getAllGroups(){
    $link = connectDB();
    $sql = "SELECT * FROM grupo";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        die("ERROR: SELECT QUERY ERROR");
    } else {
        $i =0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 4) {
                $ret[$i][$j] = $row[$j];
                $j++;
            }
            $i++;
        }
        mysqli_close($link);
    }
    return $ret;
}
function getUsersSubs($getName){
    $link = connectDB();
    $sql = "SELECT users.name,suscripcion_grupo.tipo_notificacion FROM suscripcion_grupo, users, grupo WHERE suscripcion_grupo.user_id = users.username AND suscripcion_grupo.grupo_id = grupo.id";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        die("ERROR: SELECT QUERY ERROR");
    } else {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 2) {
                //DEBUG
                //echo "<br/> " . $j . ": " . $row[$j];
                $ret[$i][] = $row[$j];
                $j++;
            }
            $i++;
        }
        mysqli_close($link);
    }
    return $ret;
}

