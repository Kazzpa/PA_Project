<?php
//======================================================================
//VALIDACION DE UNA IMAGEN
//======================================================================

//variable global ruta de la carpeta donde guardar las imagenes
$rutaImg = "img/";
$limite = 5 * 1024 * 1024; #5MB limite imagen

//Funcion para validar un string
function validarString($name, $size) {
    //regexp normal /^[0-9a-zñáéíóúü]+(.*|\s)*$/
    return preg_match("/^[[:alnum:]]+/", $name) && strlen($name) < $size && !empty(trim($name));
}

//Comprobacion de que la imagen  cumple todas las validaciones
function validarImg($img) {
    //comprueba si no hubo un error en la subida
    if ($img["error"] == 0 && soloImg($img) && limiteTamanyo($img, $GLOBALS['limite'])) {
        return true;
    } else {
        return false;
    }
}

//Comprobacion del tipo de imagen
function soloImg($archivo) {
    $bool = False;
    if ($archivo["type"] == "image/png" || $archivo["type"] == "image/jpeg") {
        $bool = True;
    }

    return $bool;
}

//Comprobacion del tamaño de imagenes
function limiteTamanyo($archivo) {
    $bool = False;
    if (isset($archivo)) {
        if ($archivo["size"] <= $GLOBALS['limite']) {
            $bool = True;
        }
    }
    return $bool;
}

//Guarda en ficheros la foto
function saveToDisk($archivo) {
    $bol = False;

    if (file_exists($archivo['tmp_name'])) {
        if (!file_exists($GLOBALS['rutaImg'])) {
            mkdir($GLOBALS['rutaImg']);
        }
        $ruta = $GLOBALS['rutaImg'] . $archivo['name'];
        if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
            $bol = True;
        }
    }
    return $bol;
}
