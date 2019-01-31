<?php

//crea la conexion con la base de datos y no la cierra.
$conexion = false;
include_once '../Logro/logros_admin.php';

//Devuelve un array con la informacion del grupo si existe, y si no falso
// 0: ID    1:name  2:descripcion   3:rutaImagen
function getGroup($getName) {
    $link = conectarDB();
    $sql = "SELECT * FROM grupo WHERE name = '" . $getName . "'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        if ($row = mysqli_fetch_array($res)) {
            $i = 0;
            while ($i < 4) {
                $ret[] = $row[$i];
                $i++;
            }
        }
    }
    return $ret;
}

//devuelve si el usuario esta suscrito o no a ese grupo
function isSubbedToGroup($user, $group) {
    $link = conectarDB();
    $sql = "SELECT users.name, suscripcion_grupo.rol FROM  users, suscripcion_grupo,"
            . " `grupo` WHERE '$user' = suscripcion_grupo.user_id AND"
            . " suscripcion_grupo.grupo_id = '$group' AND users.username = "
            . "suscripcion_grupo.user_id and suscripcion_grupo.grupo_id = grupo.id";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (mysqli_num_rows($res) > 0) {
        $ret = true;
    }
    cerrarDB();
    return $ret;
}

//devuelve una lista de grupos ordenados por namele podemos pasar un valor
// limit y offset para que nos devuelva una serie de grupos
// 0: ID    1:name  2:descripcion   3:rutaImagen
function getAllGroups($limit, $offset) {
    $link = conectarDB();
    $sql = "SELECT * FROM grupo ORDER BY name";
    if ($limit !== false && $offset !== false) {
        $sql .= " LIMIT " . $offset . " , " . $limit;
    }
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 4) {
                $ret[$i][$j] = $row[$j];
                $j++;
            }
            $i++;
        }
        cerrarDB();
    }
    return $ret;
}

//devuelve los grupos del que el user es moderador
// 0: ID    1:name  2:descripcion   3:rutaImagen
function getModGroups($user) {
    $link = conectarDB();
    $sql = "SELECT * FROM grupo, suscripcion_grupo WHERE grupo.id = "
            . "suscripcion_grupo.grupo_id AND suscripcion_grupo.user_id = '$user'"
            . " AND suscripcion_grupo.rol = '1'  ORDER BY grupo.name";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 4) {
                $ret[$i][$j] = $row[$j];
                $j++;
            }
            $i++;
        }
    }
    return $ret;
}

//modifica la imagen de un grupo existente
function modificarGrupo($id, $name, $desc, $img) {
    $bol = true;
    $con = conectarDB();
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
    cerrarDB();
    return $bol;
}

//Eliminar grupo
function eliminarGrupo($id) {
    $bol = true;
    $con = conectarDB();
//Eliminamos el grupo con el id especificado
    $consulta = 'DELETE FROM grupo WHERE id ="' . $id . '"';
    $resultado = mysqli_query($con, $consulta);

    if (!$resultado) {
        $bol = false;
    }
    cerrarDB();
    return $bol;
}

//crear grupo en db
function crearGrupo($name, $desc, $img) {
    $info[0] = true;
    $con = conectarDB();
//Hacemos una insercion en la base de datos, la fecha de registro es automatica

    $consulta = "INSERT INTO grupo ( id , name, descripcion, image_path) VALUES ( 'NULL' , '" . $name . "' , '" . $desc . "'"
            . " , '" . $GLOBALS['rutaImg'] . $img['name'] . "' )";

    $resultado = mysqli_query($con, $consulta);
    if (!$resultado) {
        $info[0] = false;
    }
    $info[1] = mysqli_insert_id($con);
    cerrarDB();
    return $info;
}

//crea relacion de suscribirse a grupo
function suscribirseGrupo($user, $grupo, $bCreador) {
    $con = conectarDB();
    $bol = false;
    if (!isSubbedToGroup($user, $grupo)) {
        $sql = "INSERT INTO suscripcion_grupo (user_id, grupo_id, id, rol)"
                . " VALUES ( '$user','$grupo', NULL, '";
        if ($bCreador) {
            $sql .= "1";
        } else {
            $sql .= "0";
        }
        $sql .= "')";
        $resultado = mysqli_query($con, $sql);
        if ($resultado) {
            $bol = true;
        }
        checkMiembros($grupo);
    }
    return $bol;
}

//elimina la relacion de un usuario con un grupo
function deSuscribirseGrupo($user, $grupo) {
    $con = conectarDB();
    $bol = false;
    if (isSubbedToGroup($user, $grupo)) {
        $sql = "DELETE FROM suscripcion_grupo WHERE user_id = '$user' AND"
                . " grupo_id = '$grupo'";
        $resultado = mysqli_query($con, $sql);
        if ($resultado) {
            $bol = true;
        }
    }
    return $bol;
}

// 0: usuario 1: tipo
function getUsersSubs($getName) {
    $link = conectarDB();
    $sql = "SELECT users.name, suscripcion_grupo.rol FROM  users, suscripcion_grupo,"
            . " `grupo` WHERE users.username = suscripcion_grupo.user_id AND"
            . " grupo.name = '$getName' AND suscripcion_grupo.grupo_id = grupo.id ORDER BY suscripcion_grupo.rol LIMIT 5";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if (!$res) {
        
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
    }
    return $ret;
}

//0: grupo_id 1:name
function getGroupsSubbed($userName) {
    $link = conectarDB();
    $sql = "SELECT grupo.name, grupo.id FROM suscripcion_grupo,"
            . " users, grupo WHERE suscripcion_grupo.user_id = users.username"
            . " AND suscripcion_grupo.rol = 1 AND suscripcion_grupo.grupo_id = grupo.id AND users.username= '" . $userName . "'";

    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 2) {
                $ret[$i][] = $row[$j];
                $j++;
            }
            $i++;
        }
    }
    return $ret;
}

//devolvemos un array con los logros obtenidos icono,descripcion y nombre
//  0:nombre_logro 1: icon_path 2:descripcion 3:puntos
function getGroupLogros($groupId) {
    $link = conectarDB();
    $sql = "SELECT logro.name, logro.icon_path, logro.descripcion, logro.puntos"
            . " FROM logro, logros_grupo, grupo WHERE   logro.id=logros_grupo.logro_id "
            . "  AND logros_grupo.group_id = " . $groupId . " AND logros_grupo.group_id = grupo.id";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $j = 0;
            while ($j < 4) {
                $ret[$i][] = $row[$j];
                $j++;
            }
            $i++;
        }
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
