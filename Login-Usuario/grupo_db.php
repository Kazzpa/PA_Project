<?php

//crea la conexion con la base de datos y no la cierra.
function connectDB() {
    include("conexion.php");
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

function getAllGroups() {
    $link = connectDB();
    $sql = "SELECT * FROM grupo";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        die("ERROR: SELECT QUERY ERROR");
    } else {
        $i = 0;
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

//modifica la imagen de un grupo existente
function modificarGrupo($id, $name, $desc, $img) {
    $bol = true;
    $con = connectDB();
//Hacemos una insercion en la base de datos, la fecha de registro es automatica
    $consulta = "UPDATE grupo SET ";
    //Hacemos comprobaciones para cambiar unicamente los campos que nos interesan
    $bol = true;
    $bol2 = false;
    if ($name != false) {
        $consulta = $consulta . "name = '" . $name . "'";
        $bol2 = true;
    }
    if ($desc != false) {
        if ($bol2) {
            $consulta = $consulta . ",";
        }
        $bol2 = true;
    }
    if ($img != false) {
        if ($bol2) {
            $consulta = $consulta . ",";
        }
        //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
        $consulta = $consulta . " image_path = '" . $GLOBALS['rutaImg'] . $img['name'] . "'";
    }
    $consulta = $consulta . " WHERE id = '" . $id . "'";
    $resultado = mysqli_query($con, $consulta);

    if (!$resultado) {
        $bol = false;
    }
    mysqli_close($con);
    return $bol;
}

//Eliminar grupo
function eliminarGrupo($id) {
    $bol = true;
    $con = connectDB();
    //Eliminamos el grupo con el id especificado
    $consulta = 'DELETE FROM grupo WHERE id ="' . $id . '"';
    $resultado = mysqli_query($con, $consulta);
    if ($resultado) {
        echo "exito";
    }
    if (!$resultado) {
        $bol = false;
        echo "<br/>" . $resultado;
        echo "error al eliminar";
    }
    mysqli_close($con);
    return $bol;
}

//crear grupo en db
function crearGrupo($name, $desc, $img) {
    $bol = true;
    $con = connectDB();
//Hacemos una insercion en la base de datos, la fecha de registro es automatica

    $consulta = "INSERT INTO grupo ( id , name, descripcion, image_path) VALUES ( 'NULL' , '" . $name . "' , '" . $desc . "'"
            . " , '" . $GLOBALS['rutaImg'] . $img['name'] . "' )";

    echo "<br> consulta: <br/>" . $consulta . "<br/>";
    $resultado = mysqli_query($con, $consulta);
    if ($resultado) {
        echo "exito";
    } else {
        $bol = false;
    }
    mysqli_close($con);
    return $bol;
}

// 0: usuario 1: tipo
function getUsersSubs($getName) {
    $link = connectDB();
    $sql = "SELECT users.name,suscripcion_grupo.rol FROM suscripcion_grupo,"
            . " users, grupo WHERE suscripcion_grupo.user_id = users.username"
            . " AND suscripcion_grupo.grupo_id = grupo.id AND grupo.name = " . $getName;
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
//0: grupo_id 1:name
function getGroupsSubbed($userName) {
    $link = connectDB();
    $sql = "SELECT grupo.name, grupo.id FROM suscripcion_grupo,"
            . " users, grupo WHERE suscripcion_grupo.user_id = users.username"
            . " AND suscripcion_grupo.rol = 1 AND suscripcion_grupo.grupo_id = grupo.id AND users.username= '" . $userName."'";

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
                $ret[$i][] = $row[$j];
                $j++;
            }
            $i++;
        }
        mysqli_close($link);
    }
    return $ret;
}

//devolvemos un array con los logros obtenidos icono,descripcion y nombre
//  0:nombre_logro 1: icon_path 2:descripcion 3:puntos
function getGroupLogros($groupId) {
    $link = connectDB();
    $sql = "SELECT logro.name, logro.icon_path, logro.descripcion, logro.puntos"
            . " FROM logro, logros_grupo, grupo WHERE   logro.id=logros_grupo.logro_id "
            . "  AND logros_grupo.group_id = " . $groupId;
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        //No deberia haber un die
        die("ERROR: SELECT QUERY ERROR");
    } else {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 4) {
                $ret[$i][] = $row[$j];
                $j++;
            }
            $i++;
        }
        mysqli_close($link);
    }
    return $ret;
}
