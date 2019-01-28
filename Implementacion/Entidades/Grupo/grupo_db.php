<?php

//crea la conexion con la base de datos y no la cierra.
$conexion = false;

//Patron singleton para conexion
function connectDB() {
    if ($GLOBALS['conexion'] == false) {
        include("../../conexion.php");
        $conexion = $con;
    } else {
        $con = $conexion;
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

function isSubbedToGroup($user, $group) {
    $link = connectDB();
    $sql = "SELECT users.name, suscripcion_grupo.rol FROM  users, suscripcion_grupo,"
            . " `grupo` WHERE '$user' = suscripcion_grupo.user_id AND"
            . " suscripcion_grupo.grupo_id = '$group' AND users.username = "
            . "suscripcion_grupo.user_id and suscripcion_grupo.grupo_id = grupo.id";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (mysqli_num_rows($res) > 0) {
        $ret = true;
    }
    mysqli_close($link);
    return $ret;
}

function getAllGroups($limit, $offset) {
    $link = connectDB();
    $sql = "SELECT * FROM grupo ORDER BY name";
    if ($limit !== false && $offset !== false) {
        $sql .= " LIMIT " . $offset . " , " . $limit;
    }
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
    $info[0] = true;
    $con = connectDB();
//Hacemos una insercion en la base de datos, la fecha de registro es automatica

    $consulta = "INSERT INTO grupo ( id , name, descripcion, image_path) VALUES ( 'NULL' , '" . $name . "' , '" . $desc . "'"
            . " , '" . $GLOBALS['rutaImg'] . $img['name'] . "' )";

    $resultado = mysqli_query($con, $consulta);
    if (!$resultado) {
        $info[0] = false;
    }
    $info[1] = mysqli_insert_id($con);
    mysqli_close($con);
    return $info;
}

//crea relacion de suscribirse a grupo
function suscribirseGrupo($user, $grupo, $bCreador) {
    $con = connectDB();
    $bol = false;
    if (!isSubbedToGroup($user, $grupo)) {
        $sql = "INSERT INTO suscripcion_grupo (user_id, grupo_id, id, rol) "
                . " VALUES ( '$user','$grupo', 'NULL', '";
        if ($bCreador) {
            $sql .= "1";
        } else {
            $sql .= "0";
        }
        $sql .= "'";
        $resultado = mysqli_query($con, $sql);
        if ($resultado) {
            $bol = true;
        }
        mysqli_close($con);
    }
    return $bol;
}

// 0: usuario 1: tipo
function getUsersSubs($getName) {
    $link = connectDB();
    $sql = "SELECT users.name, suscripcion_grupo.rol FROM  users, suscripcion_grupo,"
            . " `grupo` WHERE users.username = suscripcion_grupo.user_id AND"
            . " grupo.name = '$getName' AND suscripcion_grupo.grupo_id = grupo.id";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        mysqli_close($link);
        $ret = false;
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
            . " AND suscripcion_grupo.rol = 1 AND suscripcion_grupo.grupo_id = grupo.id AND users.username= '" . $userName . "'";

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

//retornamos el numero de grupos registrados
function getNumGrupos() {
    $link = conectarDB();
    $sql = "SELECT COUNT(name) as total FROM grupo";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($arr = mysqli_fetch_array($res)) {
        $ret = $arr['total'];
    }
    return $ret;
}