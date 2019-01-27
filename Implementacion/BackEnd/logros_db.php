<?php

//$rutaImg = "img/";

//Comprobar que tenga acceso
//chequear http://php.net/manual/en/function.mysql-real-escape-string.php
//logroname  logrodesc logroicon logrotipo logrovalor logropuntos
//crea la conexion con la base de datos y no la cierra.
function conectarDB() {
    include("conexion.php");
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

function getLogro($name) {
    $link = conectarDB();
    $ret = false;
    if ($link !== false) {
        //Hacemos una insercion en la base de datos, la fecha de registro es automatica
        $consulta = 'SELECT id, name, icon_path, descripcion, tipo, valor, puntos FROM logro WHERE name = "' . $name . '"';
        $resultado = mysqli_query($link, $consulta);
        if (!$resultado) {
            mysqli_close($link);
            die("ERROR: SELECT QUERY ERROR");
        } else {
            if ($row = mysqli_fetch_array($resultado)) {
                $i = 0;
                while ($i < 7) {
                    $ret[] = $row[$i];
                    $i++;
                }
            }
        }
        mysqli_close($link);
    }
    return $ret;
}

//modifica la imagen de un grupo existente
function modificarLogro($id, $name, $img, $desc, $tipo, $valor, $puntos) {
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
        if ($puntos !== false) {
            if ($bol2) {
                $consulta = $consulta . ",";
            }
            //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
            $consulta .= " puntos = '" . $puntos . "'";
            $bol2 = true;
        }
        $consulta = $consulta . " WHERE id = '" . $id . "'";
        $resultado = mysqli_query($con, $consulta);

        if ($resultado) {
            $bol = true;
        }
        mysqli_close($con);
    }else{
    }
    return $bol;
}

//Eliminar grupo
function eliminarLogro($id) {
    $bol = true;
    $con = conectarDB();
    //Eliminamos el grupo con el id especificado
    $consulta = 'DELETE FROM logro WHERE id ="' . $id . '"';
    $resultado = mysqli_query($con, $consulta);
    if (!$resultado) {
        $bol = false;
    }
    mysqli_close($con);
    return $bol;
}
