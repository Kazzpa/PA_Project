<?php
//variable global ruta de la carpeta donde guardar las imagenes
$rutaImg = "img/";
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
        $consulta = $consulta . "name = '" . $name."'";
        $bol2 = true;
    }
    if ($desc != false) {
        if($bol2){
            $consulta = $consulta. ",";
        }
        $bol2 = true;
        $consulta = $consulta . " descripcion = '" . $desc."'";
        echo "probao";
        echo $consulta;
    }
    if ($img != false) {
        if($bol2){
            $consulta = $consulta. ",";
        }
        print_r($img);
        if(file_exists($img['tmp_name'])){
        $hash = md5_file($img['tmp_name']);
        }else{
            echo "no existe el archivo";
        }
        //usamos variable global por si queremos cambiar la ruta donde guardar las imagenes
        $consulta = $consulta . " img = '".$GLOBALS['rutaImg'] . $img['name']."', imgHash = '" . $hash."'";
    }
    $consulta = $consulta." WHERE id = '" . $id."'";
    echo "<br> consulta: <br/>".$consulta."<br/>";
    $resultado = mysqli_query($con, $consulta);
    if($resultado){
        echo "exito";
    }
    if (!$resultado) {
        $bol = false;
    }
    mysqli_close($con);
    return $bol;
}

function getUsersSubs($getName) {
    $link = connectDB();
    $sql = "SELECT users.name,suscripcion_grupo.tipo_notificacion FROM suscripcion_grupo, users, grupo WHERE suscripcion_grupo.user_id = users.username AND suscripcion_grupo.grupo_id = grupo.id AND grupo.name = " . $getName;
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
