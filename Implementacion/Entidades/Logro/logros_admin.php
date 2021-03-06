<?php

include_once '../Grupo/grupo_db.php';
include_once ('logros_db.php');
include_once ('../../validation.php');

function panelLogrosLogin() {
    if (!isset($_SESSION['username'])) {
        header("Location: ../../index.php");
    }
    if ($_SESSION['tipo'] == 1) {
        $limite = 5 * 1024 * 1024;
        $bol = checkEnviadoAdmin();
        if ($bol < 5) {
            switch ($bol) {
                case 1:
                    echo '<h3 class="alert alert-warning" role="alert">
                            Logro eliminado con exito</h3>';
                    break;
                case 2:
                    echo '<h3 class="alert alert-info" role="alert">
                            Logro creado con exito!</h3>';
                    break;
                case 3:
                    echo '<h3 class="alert alert-warning" role="alert">
                            Logro no creado, compruebe los campos.</h3>';
                case 4:
                    echo '<h3 class="alert alert-info" role="alert">
                            Logro Modificado con exito!</h3>';
                    break;
            }
            echo (formBuscarLogro());
            echo (formCrearLogro());
        } else {
            switch ($bol) {
                case 5:
                    echo '<h3 class="alert alert-warning" role="alert">
                            Logro no modificado, compruebe los campos.</h3>';
                    break;
                case 6:
                    echo '<h3 class="alert alert-info" role="alert">
                            Logro encontrado con exito.</h3>';
                    break;
            }
            if (isset($_SESSION['logro'])) {
                echo (formModLogro());
            }
        }
        cerrarDB();
    }
}

//Formulario para crear logro
function formCrearLogro() {
    return '
                <form id="crearLogro" action="" method="POST" enctype="multipart/form-data" >
            <div class="row">
                <div class="form-group col-md-4">
                    <b>Nombre logro: </b>
                    <input type="text" class="form-control" name="logroname" required><br/>
                </div>
                <div class="form-group col-md-8 custom-file">
                    <b>Icono del logro: </b><br/>
                    <input type="file" class="custom-file-input " id="customFile" name="logroicon" accept="image/x-png,image/gif,image/jpeg" required>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <b>Descripcion del logro</b>
                    <input type="text" class="form-control" name="logrodesc"  required><br/>
                </div>
                <div class="form-group col-md-4">
                    <b>Tipo de logro</b>
                    <select class="custom-select" name="logrotipo" required>
                    <option value="0" selected>N&uacute;mero de miembros</option>
                    <option value="1">N&uacute;mero de comentarios</option>
                    <option value="2">N&uacute;mero de fotos</option>
                    <option value="3">N&uacute;mero de eventos</option>
                    <option value="4">Rey de la web o especial</option>
                  </select>
                </div>
                <div class="form-group col-md-4">
                    <b>Valor necesario para conseguirlo</b>
                    <input type="number" class="form-control" name="logrovalor" min="1" required><br/>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4">
                    <input type="submit" name="logrocrear" value="Crear">
                </div>
            </div>
            </form>
                ';
}

//Formulario para seleccionar un logro especifico por nombre
function formBuscarLogro() {
    return '<h4> Buscar logro a tratar </h4>
        <div >
            <form id="buscarLogro"action="" method="POST">
                <div class="form-group">
                    <b>Nombre: </b><input type="text" class="form-control" name="logro" required>
                    <input type="submit" name="BuscarLogro" value="Buscar">
                </div>
            </form></div>';
}

//Comprueba si existe el logro especificado
//logro session:
//0:id 1:name 2:icon_path 3:descripcion 4:tipo 5:valor 6:puntos
function formModLogro() {
    $str = '<h4> Panel Modificar logro </h4>
                <form id="modBorrarLogro" action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <b>Modificar Nombre: </b><i>"' . utf8_decode($_SESSION['logro'][1]) . '"</i><br/>
                    <input type="text" class="form-control" name="logroName"><br/>
                    </div>';
    $str .= '<b>Modificar Imagen: </b><br/>';
    if (file_exists($_SESSION['logro'][2])) {
        $str .= '<img class="img-responsive preview"  src="' . $_SESSION['logro'][2] . '" alt = "imagen de logro:' . $_SESSION['logro'][1] . '"><br/>';
    }
    $str .= '<div class="form-group"><input type="file" class="form-control" name="logroImg"><br/></div>
                    <div class="form-group">
                        <b>Modificar descripcion: </b>
                        <br/><i>"' . $_SESSION['logro'][3] . '" </i><br/>
                        <input type="text" class="form-control" name="logroDesc"><br/>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                        <b>Modificar tipo: </b>
                        <select class="" name="logrotipo">
                        <option value="0"';
    if ($_SESSION['logro'][4] == 0) {
        $str .= ' selected';
    }
    $str .= '>N&uacute;mero de miembros</option>
                        <option value="1"';
    if ($_SESSION['logro'][4] == 1) {
        $str .= ' selected';
    }
    $str .= '>N&uacute;mero de comentarios</option>
                        <option value="2"';
    if ($_SESSION['logro'][4] == 2) {
        $str .= ' selected';
    }
    $str .= '>N&uacute;mero de fotos</option>
                        <option value="3"';
    if ($_SESSION['logro'][4] == 3) {
        $str .= ' selected';
    }
    $str .= '>N&uacute;mero de eventos</option>
                        <option value="4"';
    if ($_SESSION['logro'][4] == 4) {
        $str .= ' selected';
    }
    $str .= '>N&uacute;mero de puntos</option>
                        <option value="5"';
    if ($_SESSION['logro'][4] == 5) {
        $str .= ' selected';
    }
    $str .= '>Rey de la web o especial</option>
                        </select>
                    </div></div>
                    <div class="form-group col-md-6">
                        <b>Valor necesario para conseguirlo</b>
                        "<i>' . $_SESSION['logro'][5] . ' </i>"
                        <input type="number" class="form-control" name="logrovalor" min="1" placeholder="valor"><br/>
                    </div>
                    <input type="submit" name="modLogro" value="Modificar">
                    <input type="submit" class="btn btn-danger" name="EliminarLogro" value="Eliminar">
            </form>';
    return $str;
}

//logroName logroImg logroDesc logrotipo logrovalor logropuntos
function trataModLogro() {
    $bol = false;
    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'logroName' => FILTER_SANITIZE_STRING,
        'logroDesc' => FILTER_SANITIZE_STRING,
        'logrotipo' => FILTER_SANITIZE_NUMBER_INT,
        'logrovalor' => FILTER_SANITIZE_NUMBER_INT,
    );
    $entradas = filter_input_array(INPUT_POST, $filtros);
    //no valido a fondo tipo,valor y puntos WIP
    $name = false;
    $desc = false;
    $img = false;
    $tipo = false;
    $valor = false;
    if (isset($_POST['logroName'])) {
        if (validarString($entradas['logroName'], 50)) {
            $name = $entradas['logroName'];
            echo $name;
        }
    }
    if (isset($_POST['logroDesc'])) {
        if (validarString($entradas['logroDesc'], 200)) {
            $desc = $entradas['logroDesc'];
        }
    }
    if (isset($_FILES['logroicon'])) {
        if (validarImg($_FILES['logroicon'])) {
            $img = $_FILES['logroicon'];
        }
    }
    if (isset($_POST['logrotipo'])) {
        if (is_numeric($_POST['logrotipo'])) {
            $tipo = $entradas['logrotipo'];
        }
    }
    if (isset($_POST['logrovalor'])) {
        if (is_numeric($_POST['logrovalor'])) {
            $valor = $entradas['logrovalor'];
        }
    }
    $guardadoDB = modificarLogro($_SESSION['logro'][0], $name, $img, $desc, $tipo, $valor);
    if ($guardadoDB && $img !== false) {
        saveToDisk($img);
    }
    if ($guardadoDB)
        $bol = true;
    return $bol;
}

//logroName logroImg logroDesc logrotipo logrovalor logropuntos
function checkEnviadoAdmin() {
    $bol = -1;
    if (isset($_POST['logrocrear'])) {
        $bol = validarCrearLogro();
        if ($bol) {
            $bol = 2;
        } else {
            $bol = 3;
        }
    } else if (isset($_SESSION['logro']) && isset($_POST['modLogro'])) {
        if (isset($_POST['logroName']) || isset($_FILES['logroImg']) || isset($_POST['logroDesc']) || isset($_POST['logrotipo']) || isset($_POST['logrovalor'])) {
            $bol = trataModLogro();
            if ($bol) {
                $bol = 4;

                unset($_SESSION['logro']);
            } else {
                $bol = 5;
            }
        }
    } else if (isset($_SESSION['logro']) && isset($_POST['EliminarLogro'])) {
        $bol = eliminarLogro($_SESSION['logro'][0]);
        unset($_SESSION['logro']);
        if ($bol) {
            $bol = 1;
        }
    } else if (isset($_POST['BuscarLogro'])) {
        $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
            'logro' => FILTER_SANITIZE_STRING
        );
        $entradas = filter_input_array(INPUT_POST, $filtros);
        $logro = getLogro($entradas['logro']);
        if ($logro !== false) {
            //guardamos la info del grupo en sesion
            $_SESSION['logro'] = $logro;
            $bol = 6;
        } else {
            $bol = 0;
        }
    }
    return $bol;
}

//comprobamos: logroname  logrodesc logroicon logrotipo logrovalor logropuntos
//Devolvemos true si son validos, falso si no
function validarCrearLogro() {
    $bol = false;
    if (isset($_POST['logroname']) && isset($_POST['logrodesc']) && isset($_FILES['logroicon']) && isset($_POST['logrotipo']) && isset($_POST['logrovalor'])) {
        $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
            'logroname' => FILTER_SANITIZE_STRING,
            'logrodesc' => FILTER_SANITIZE_STRING,
            'logrotipo' => FILTER_SANITIZE_NUMBER_INT,
            'logrovalor' => FILTER_SANITIZE_NUMBER_INT,
        );
        $entradas = filter_input_array(INPUT_POST, $filtros);
        //no valido a fondo tipo,valor y puntos WIP
        if (validarString($entradas['logroname'], 50) && validarString($entradas['logrodesc'], 200) && validarImg($_FILES['logroicon']) && is_numeric($_POST['logrotipo']) && is_numeric($_POST['logrovalor'])) {
            $name = $entradas['logroname'];
            $desc = $entradas['logrodesc'];
            $img = $_FILES['logroicon'];
            $tipo = $entradas['logrotipo'];
            $valor = $entradas['logrovalor'];
            $guardadoDB = crearLogro($name, $img, $desc, $tipo, $valor);
            if ($guardadoDB) {
                saveToDisk($img);
                $bol = true;
            }
        }
    }
    return $bol;
}

//Comprobamos los logros relacionados con miembros
function checkMiembros($groupId) {
    $logros_miembros = getLogros(0);
    // si no hay logros de miembros no hacemos ningun calculo mas
    if ($logros_miembros !== false) {
        $numMiembros = numMiembros($groupId);
        if ($numMiembros !== false) {
            for ($i = 0; $i < sizeof($logros_miembros); $i++) {
                //comprobamos si excede el valor del logro
                // si es asi añadimos el logro en caso de que aun no lo tenga
                // eso estara controlado en addLogro
                if ($numMiembros >= $logros_miembros[$i][1]) {
                    if (addLogro($logros_miembros[$i][0], $groupId)) {
                        //logro añadido
                    }
                }
            }
        }
    }
    cerrarDB();
}

//Comprobamos los logros relacionados con comentarios
function checkComentarios($groupId) {
    $logros_comentarios = getLogros(1);
    // si no hay logros de miembros no hacemos ningun calculo mas
    if ($logros_comentarios !== false) {
        $numComentarios = numComentarios($groupId);
        if ($numComentarios !== false) {
            for ($i = 0; $i < sizeof($logros_comentarios); $i++) {
                //comprobamos si excede el valor del logro
                // si es asi añadimos el logro en caso de que aun no lo tenga
                // eso estara controlado en addLogro
                if ($numComentarios >= $logros_comentarios[$i][1]) {
                    if (addLogro($logros_comentarios[$i][0], $groupId)) {
                        //logro añadido
                    }
                }
            }
        }
    }
    cerrarDB();
}

//Comprobamos logros relacionados con fotos
function checkFotos($groupId) {
    $logros_fotos = getLogros(2);
    // si no hay logros de miembros no hacemos ningun calculo mas
    if ($logros_fotos !== false) {
        $numFotos = numFotos($groupId);
        if ($numFotos !== false) {
            for ($i = 0; $i < sizeof($logros_fotos); $i++) {
                //comprobamos si excede el valor del logro
                // si es asi añadimos el logro en caso de que aun no lo tenga
                // eso estara controlado en addLogro
                if ($numFotos >= $logros_fotos[$i][1]) {
                    if (addLogro($logros_fotos[$i][0], $groupId)) {
                        //logro añadido
                    }
                }
            }
        }
    }
    cerrarDB();
}

//Comprobamos logros relacionados con eventos
function checkEventos($groupId) {
    $logros_eventos = getLogros(3);
    // si no hay logros de miembros no hacemos ningun calculo mas
    if ($logros_eventos !== false) {
        $numEventos = numEvents($groupId);
        if ($numEventos !== false) {
            for ($i = 0; $i < sizeof($logros_eventos); $i++) {
                //comprobamos si excede el valor del logro
                // si es asi añadimos el logro en caso de que aun no lo tenga
                // eso estara controlado en addLogro
                if ($numEventos >= $logros_eventos[$i][1]) {
                    if (addLogro($logros_eventos[$i][0], $groupId)) {
                        //logro añadido
                    }
                } else {
                    //quitar logro en caso de que este por debajo del umbral
                }
            }
        }
    }
    cerrarDB();
}

//WIP: PA DESPUES Comprobamos logros relacionados con eventos
function checkPuntos($groupId) {
    $logros_eventos = getLogros(3);
    // si no hay logros de miembros no hacemos ningun calculo mas
    if ($logros_eventos !== false) {
        $numEventos = numEvents($groupId);
        if ($numEventos !== false) {
            for ($i = 0; $i < sizeof($logros_eventos); $i++) {
                //comprobamos si excede el valor del logro
                // si es asi añadimos el logro en caso de que aun no lo tenga
                // eso estara controlado en addLogro
                if ($numEventos >= $logros_eventos[$i][1]) {
                    if (addLogro($logros_eventos[$i][0], $groupId)) {
                        //logro añadido
                    }
                } else {
                    //quitar logro en caso de que este por debajo del umbral
                }
            }
        }
    }
    cerrarDB();
}
