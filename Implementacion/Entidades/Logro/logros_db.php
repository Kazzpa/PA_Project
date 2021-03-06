<?php

//======================================================================
//LIBRERIA DE FUNCIONES PARA LOGROS
//======================================================================
        
//crea la conexion con la base de datos y no la cierra.
$conexion = false;

//Patron singleton para conexion
function conectarDB() {
    if ($GLOBALS['conexion'] == false) {
        include("../../conexion.php");
        $conexion = $con;
    } else {
        $con = $conexion;
    }
    return $con;
}

function cerrarDB() {
    if ($GLOBALS['conexion'] != false) {
        mysqli_close($con);
        $conexion = false;
    }
}

//Insertamos un logro en la DB
function crearLogro($name, $icon, $desc, $tipo, $valor) {
    $link = conectarDB();
    $bol = false;
    if ($link !== false) {
        $name = mysqli_real_escape_string($link, $name);
        $icon = mysqli_real_escape_string($link, $icon['name']);
        $desc = mysqli_real_escape_string($link, $desc);
        //Hacemos una insercion en la base de datos, la fecha de registro es automatica
        $consulta = "INSERT INTO logro ( id , name, icon_path, descripcion, tipo, valor)"
                . " VALUES ( 'NULL' , '" . $name . "' , '" . $GLOBALS['rutaImg']
                . $icon . "' , '" . $desc . "', '" . $tipo . "', '" . $valor
                . "' )";
        $resultado = mysqli_query($link, $consulta);
        if ($resultado) {
            $bol = true;
        }
    }
    return $bol;
}

//Obtenemos informacion de un logro por su nombre
function getLogro($name) {
    $link = conectarDB();
    $ret = false;
    if ($link !== false) {
        //Hacemos una insercion en la base de datos, la fecha de registro es automatica
        $consulta = 'SELECT id, name, icon_path, descripcion, tipo, valor '
                . 'FROM logro WHERE name = "' . $name . '"';
        $resultado = mysqli_query($link, $consulta);
        if ($resultado) {
            if ($row = mysqli_fetch_array($resultado)) {
                $i = 0;
                while ($i < 6) {
                    $ret[] = $row[$i];
                    $i++;
                }
            }
        }
    }
    return $ret;
}

//modificamos los campos de un logro
function modificarLogro($id, $name, $img, $desc, $tipo, $valor) {
    $bol = false;
    $con = conectarDB();
    //Hacemos una insercion en la base de datos, la fecha de registro es automatica
    if ($con !== false) {
        $consulta = "UPDATE logro SET ";
        //Hacemos comprobaciones para cambiar unicamente los campos que nos interesan
        $bol2 = false;
        if ($name !== false) {
            $consulta = $consulta . "name = '" . $name . "'";
            $bol2 = true;
        }
        if ($img !== false) {
            if ($bol2) {
                $consulta .= ",";
            }
            $consulta .= " icon_path = '" . $GLOBALS['rutaImg'] . $img['name'] . "'";
            $bol2 = true;
        }
        if ($desc !== false) {
            if ($bol2) {
                $consulta = $consulta . ",";
            }
            //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
            $consulta .= " descripcion = '" . $desc . "'";
            $bol2 = true;
        }
        if ($tipo !== false) {
            if ($bol2) {
                $consulta = $consulta . ",";
            }
            //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
            $consulta .= " tipo = '" . $tipo . "'";
            $bol2 = true;
        }
        if ($valor !== false) {
            if ($bol2) {
                $consulta = $consulta . ",";
            }
            //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
            $consulta .= " valor = '" . $valor . "'";
            $bol2 = true;
        }
        $consulta = $consulta . " WHERE id = '" . $id . "'";
        $resultado = mysqli_query($con, $consulta);

        if ($resultado) {
            $bol = true;
        }
    } else {
        
    }
    return $bol;
}

//Eliminar logro por id
function eliminarLogro($id) {
    $bol = true;
    $con = conectarDB();
    //Eliminamos el grupo con el id especificado
    $consulta = 'DELETE FROM logro WHERE id ="' . $id . '"';

    $resultado = mysqli_query($con, $consulta);
    $consulta = "DELETE FROM logros_grupo WHERE logro_id = '$id'";
    $resultado = mysqli_query($con, $consulta);
    if (!$resultado) {
        $bol = false;
    }
    return $bol;
}

//devuelve el numero de miembros relacionadas con ese grupo
function numMiembros($grupoId) {
    $link = conectarDB();
    $sql = "SELECT COUNT(suscripcion_grupo.id) as total FROM suscripcion_grupo WHERE "
            . "suscripcion_grupo.grupo_id = '$grupoId'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($arr = mysqli_fetch_array($res)) {
        $ret = $arr['total'];
    }
    return $ret;
}

//devuelve el numero de comentarios relacionadas con ese grupo
function numComentarios($grupoId) {
    $link = conectarDB();
    $sql = "SELECT COUNT(posts.id) as total FROM events, posts WHERE "
            . "posts.eventId = events.id and events.group_id = '$grupoId'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($arr = mysqli_fetch_array($res)) {
        $ret = $arr['total'];
    }
    return $ret;
}

//devuelve el numero de fotos relacionadas con ese grupo
function numFotos($grupoId) {
    $link = conectarDB();
    $sql = "SELECT COUNT(gallery.id) as total FROM gallery WHERE "
            . "grupo = '$grupoId'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($arr = mysqli_fetch_array($res)) {
        $ret = $arr['total'];
    }
    return $ret;
}

//devuelve el numero de eventos relacionadas con ese grupo
function numEvents($grupoId) {
    $link = conectarDB();
    $sql = "SELECT COUNT(events.group_id) as total FROM events WHERE "
            . "group_id = '$grupoId'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res !== false) {
        if ($arr = mysqli_fetch_array($res)) {
            $ret = $arr['total'];
        }
    }
    return $ret;
}

//devuelve los logros que son del tipo que le pasamos
function getLogros($tipo) {
    $link = conectarDB();
    $sql = "SELECT * FROM logro where logro.tipo = '$tipo'";
    $res = mysqli_query($link, $sql);
    $ret = false;
    if ($res) {
        $i = 0;
        while ($row = mysqli_fetch_array($res)) {
            $ret[$i][0] = $row['id'];
            $ret[$i][1] = $row['valor'];
            $ret[$i][2] = $row['puntos'];
            $i++;
        }
    }
    return $ret;
}

//funcion para añadir un logro
function addLogro($idLogro, $grupoId) {
    $link = conectarDB();
    $bol = false;
    if ($link !== false) {
        $consulta = "SELECT * FROM logros_grupo WHERE  group_id  = "
                . "'$grupoId' AND logro_id = '$idLogro'";
        $resultado = mysqli_query($link, $consulta);
        if (mysqli_num_rows($resultado) == 0) {
            //Hacemos una insercion en la base de datos
            $consulta = "INSERT INTO logros_grupo ( group_id , logro_id)"
                    . " VALUES ( '$grupoId' , '$idLogro' )";
            $resultado = mysqli_query($link, $consulta);
            if ($resultado) {
                $bol = true;
            }
        }
    }
    return $bol;
}
