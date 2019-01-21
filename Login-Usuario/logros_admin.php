<?php

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
if ($_SESSION['tipo'] == 1) {
    include ('logros_db.php');
    include ('validation.php');
    $limite = 5 * 1024 * 1024;

//Formulario para crear logro
    function formCrearLogro() {
        return '
                <form action="" method="POST" enctype="multipart/form-data" >
            
            <div class="form-group col-md-4">
                <b>Nombre logro: </b>
                <input type="text" class="form-control" name="logroname" placeholder="Nombre icono" required><br/>
            </div>
            <div class="form-group col-md-4 custom-file">
                <b>Icono del logro: </b><br/>
                <input type="file" class="custom-file-input" id="customFile" name="logroicon" accept="image/x-png,image/gif,image/jpeg" required>
            </div>
            <div class="form-group col-md-4">
                <b>Descripcion del logro</b>(ej: 100 miembros en el grupo):
                <input type="text" class="form-control" name="logrodesc" placeholder="Descripcion" required><br/>
            </div>
            <div class="form-group col-md-4">
                <b>Tipo de logro</b>
                <select class="custom-select" name="logrotipo" required>
                <option value="0" selected>N&uacute;mero de miembros</option>
                <option value="1">N&uacute;mero de comentarios</option>
                <option value="2">N&uacute;mero de fotos</option>
                <option value="3">N&uacute;mero de eventos</option>
                <option value="4">N&uacute;mero de puntos</option>
                <option value="5">Rey de la web o especial</option>
              </select>
            </div>
            <div class="form-group col-md-4">
                <b>Valor necesario para conseguirlo</b>
                <input type="number" class="form-control" name="logrovalor" min="1" placeholder="valor" required><br/>
            </div>
            <div class="form-group col-md-4">
                <b>Puntos a obtener</b>
                <input type="number" class="form-control" name="logropuntos" placeholder="puntos" required><br/>
            </div>
            <input type="submit" class="btn btn-primary" name="logrocrear" value="Crear">
            </form>
                ';
    }

//Formulario para seleccionar un logro especifico por nombre
    function formBuscarLogro() {
        return '<h4> Buscar logro a tratar </h4>
            <form action="" method="POST">
                <div class="form-group">
                    <b>Nombre: </b><input type="text" class="form-control" name="logro" placeholder="Nombre logro">
                    <input type="submit" class="btn btn-primary" name="BuscarLogro" value="Buscar">
                </div>
            </form>';
    }

//Comprueba si existe el logro especificado
//logro session:
//0:id 1:name 2:icon_path 3:descripcion 4:tipo 5:valor 6:puntos
    function formModLogro() {
        $str = '<h4> Panel Modificar logro </h4>
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <b>Modificar Nombre: </b><i>"' . utf8_decode($_SESSION['logro'][1]) . '"</i><br/>
                    <input type="text" class="form-control" name="logroName" placeholder="Nombre"><br/>
                    </div>';
        $str .= '<b>Modificar Imagen: </b><br/>';
        if (file_exists($_SESSION['logro'][2])) {
            $str .= '<img src="' . $_SESSION['logro'][2] . '" alt = "imagen de logro:' . $_SESSION['logro'][1] . '"><br/>';
        }
        $str .= '<div class="form-group"><input type="file" class="form-control" name="logroImg" placeholder="ruta imagen"><br/></div>
                    <div class="form-group">
                        <b>Modificar descripcion: </b>
                        <br/><i>"' . $_SESSION['logro'][3] . '" </i><br/>
                        <input type="text" class="form-control" name="logroDesc" placeholder="Descripcion"><br/>
                    </div>
                    <div class="form-group">
                        <div class="form-group col-md-4">
                        <b>Modificar tipo: </b>
                        <select class="custom-select" name="logrotipo">
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
                    <div class="form-group col-md-4">
                        <b>Valor necesario para conseguirlo</b>
                        "<i>' . $_SESSION['logro'][5] . ' </i>"
                        <input type="number" class="form-control" name="logrovalor" min="1" placeholder="valor"><br/>
                    </div>
                    <div class="form-group col-md-4">
                        <b>Puntos a obtener</b>
                        "<i>' . $_SESSION['logro'][6] . ' </i>"
                        <input type="number" class="form-control" name="logropuntos" placeholder="puntos"><br/>
                    </div>
                    <input type="submit" class="btn btn-primary" name="modLogro" value="Modificar">
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
            'logropuntos' => FILTER_SANITIZE_NUMBER_INT,
        );
        $entradas = filter_input_array(INPUT_POST, $filtros);
        //no valido a fondo tipo,valor y puntos WIP
        $name = false;
        $desc = false;
        $img = false;
        $tipo = false;
        $valor = false;
        $puntos = false;
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
            $tipo = $entradas['logrotipo'];
        }
        if (isset($_POST['logrovalor'])) {
            $valor = $entradas['logrovalor'];
        }
        if (isset($_POST['logropuntos'])) {
            $puntos = $entradas['logropuntos'];
        }
        $guardadoDB = modificarLogro($_SESSION['logro'][0], $name, $img, $desc, $tipo, $valor, $puntos);
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
            if (isset($_POST['logroName']) || isset($_FILES['logroImg']) || isset($_POST['logroDesc']) || isset($_POST['logrotipo']) || isset($_POST['logrovalor']) || isset($_POST['logropuntos'])) {
                $bol = trataModLogro();
                if ($bol) {
                    $bol = 4;

                    unset($_SESSION['logro']);
                } else {
                    $bol = 5;
                }
            }
        } else if (isset($_SESSION['logro']) && isset($_POST['EliminarLogro'])) {
            $bol = eliminarLogro($_SESSION['grupo'][0]);
            unset($_SESSION['grupo']);
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

// comprobamos : logroname  logrodesc logroicon logrotipo logrovalor logropuntos
//Devolvemos true si son validos, falso si no
    function validarCrearLogro() {
        $bol = false;
        if (isset($_POST['logroname']) && isset($_POST['logrodesc']) && isset($_FILES['logroicon']) && isset($_POST['logrotipo']) && isset($_POST['logrovalor']) && isset($_POST['logropuntos'])) {
            $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                'logroname' => FILTER_SANITIZE_STRING,
                'logrodesc' => FILTER_SANITIZE_STRING,
                'logrotipo' => FILTER_SANITIZE_NUMBER_INT,
                'logrovalor' => FILTER_SANITIZE_NUMBER_INT,
                'logropuntos' => FILTER_SANITIZE_NUMBER_INT,
            );
            $entradas = filter_input_array(INPUT_POST, $filtros);
            //no valido a fondo tipo,valor y puntos WIP
            if (validarString($entradas['logroname'], 50) && validarString($entradas['logrodesc'], 200) && validarImg($_FILES['logroicon'])) {
                $name = $entradas['logroname'];
                $desc = $entradas['logrodesc'];
                $img = $_FILES['logroicon'];
                $tipo = $entradas['logrotipo'];
                $valor = $entradas['logrovalor'];
                $puntos = $entradas['logropuntos'];
                $guardadoDB = crearLogro($name, $img, $desc, $tipo, $valor, $puntos);
                if ($guardadoDB) {
                    saveToDisk($img);
                    $bol = true;
                }
            }
        }
        return $bol;
    }

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
}