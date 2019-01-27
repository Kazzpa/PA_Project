<?php

//variable global ruta de la carpeta donde guardar las imagenes
$rutaImg = "img/";
$limite = 5 * 1024 * 1024; #5MB limite imagen

function validarString($name, $size) {
    //regexp normal /^[0-9a-zñáéíóúü]+(.*|\s)*$/
    return preg_match("/^[[:alnum:]]+/", $name) && strlen($name) < $size && !empty(trim($name));
}

function validarImg($img) {
    //comprueba si no hubo un error en la subida
    if ($img["error"] == 0 && soloImg($img) && limiteTamanyo($img, $GLOBALS['limite'])) {
        return true;
    } else {
        return false;
    }
}

function soloImg($archivo) {
    $bool = False;
    if ($archivo["type"] == "image/png" || $archivo["type"] == "image/jpeg") {
        $bool = True;
    }

    return $bool;
}

function limiteTamanyo($archivo) {
    $bool = False;
    if (isset($archivo)) {
        if ($archivo["size"] <= $GLOBALS['limite']) {
            $bool = True;
        }
    }
    return $bool;
}

//guarda en ficheros la foto
function saveToDisk($archivo) {
    $bol = False;

    if (file_exists($archivo['tmp_name'])) {
        echo 'existe el archivo en temporales';
        if (!file_exists($GLOBALS['rutaImg'])) {
            echo 'no existia carpeta img';
            mkdir($GLOBALS['rutaImg']);
        }else{
            echo "existia carpeta img";
        }
        $ruta = $GLOBALS['rutaImg'] . $archivo['name'];
        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
            echo 'movido a carpeta que deberia';
            $bol = True;
        }
    }
    return $bol;
}
