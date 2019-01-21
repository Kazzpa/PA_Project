<?php

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}
if ($_SESSION['tipo'] == 1) {
    include ('grupo_db.php');
    include ('validation.php');


    $bol = compruebaEnviado();


    if (!$bol) {
        echo (formGrupo());
        echo (formCrearGrupo());
    } else {
        echo (formModGrupo());
    }
}

//imprime un formulario para buscar/seleccionar un grupo
function formGrupo() {
    return '<h4> Buscar Grupo a tratar </h4>
<form action="" method="POST">
    <div class="form-group">
        <b>Nombre: </b><input type="text" class="form-control" name="grupo" placeholder="Nombre grupo">
        <input type="submit" class="btn btn-primary" name="BuscarGrupo" value="Buscar">
    </div>
</form>';
}

//Comprueba si existe el grupo especificado
function formModGrupo() {
    $str = '<h4> Panel Modificar grupo </h4>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <b>Modificar Nombre: </b><i>"' . utf8_decode($_SESSION['grupo'][1]) . '"</i><br/>
        <input type="text" class="form-control" name="grupoName" placeholder=""><br/>
    </div>
    <div class="form-group">
        <b>Modificar descripcion: </b>
        <br/><i>"' . $_SESSION['grupo'][2] . '" </i><br/>
        <input type="text" class="form-control" name="grupoDesc" placeholder="Descripcion"><br/>
    </div>
    <div class="form-group">
        <b>Modificar Imagen: </b><br/>';
    if (file_exists($_SESSION['grupo'][3])) {
        $str .= '<img src="' . $_SESSION['grupo'][3] . '" alt="imagen de ' . $_SESSION['grupo'][1] . 'width="10%"></img><br/>';
    }
    $str .= '<input type="file" class="form-control" name="grupoImg" placeholder="ruta imagen"><br/>
    </div>
    <input type="submit" class="btn btn-primary" name="ModGrupo" value="Modificar">
    <input type="submit" class="btn btn-danger" name="EliminarGrupo" value="Eliminar">
</form>';
    return $str;
}

function formCrearGrupo() {
    return '<h4> Panel Creacion de Grupo </h4>
<form action="" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <b>Nombre: </b><br/>
        <input type="text" class="form-control" name="grupoName" placeholder="Nombre de grupo"><br/>
    </div><div class="form-group">
        <b>Descripcion: </b><br/>
        <input type="text" class="form-control" name="grupoDesc" placeholder="Descripcion"><br/>
    </div><div class="form-group">
        <b>Imagen: </b><br/>
        <input type="file" class="form-control-file" name="grupoImg" placeholder="Seleccione imagen"><br/>
    </div>
    <input type="submit" class="btn btn-primary" name="crearGrupo" value="Crear">

</form>';
}

//Devuelve falso si no se ha enviado, o si no esta el grupo registrado
//si esta registrado, lo guarda en una variable de sesion
function compruebaEnviado() {
    if (isset($_POST['grupo']) || !isset($_SESSION['grupo']) && !isset($_POST['crearGrupo'])) {
        $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
            'grupo' => FILTER_SANITIZE_STRING
        );
        $entradas = filter_input_array(INPUT_POST, $filtros);
        $grupo = getGroup($entradas['grupo']);
        if ($grupo != false) {
//guardamos la info del grupo en sesion
            $_SESSION['grupo'] = $grupo;
            return true;
        } else {
            return false;
        }//modificar
    } else if (isset($_POST['ModGrupo']) && isset($_SESSION['grupo'])) {
        if (isset($_POST['grupoName']) || isset($_POST['grupoDesc']) || isset($_FILES['grupoImg'])) {
            trataModGrupo();
        }
    } else if (isset($_POST['EliminarGrupo']) && isset($_SESSION['grupo'])) {
        trataEliminarGrupo();
    } else if (isset($_POST['crearGrupo']) && !isset($_SESSION['grupo'])) {
        if (isset($_POST['grupoName']) && isset($_POST['grupoDesc']) && isset($_FILES['grupoImg'])) {
            trataCrearGrupo();
        }
    }
//por defecto devolvemos falso
    return false;
}

//Tratamiento del formulario de modificar grupo
function trataModGrupo() {
    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'grupoName' => FILTER_SANITIZE_STRING,
        'grupoDesc' => FILTER_SANITIZE_STRING
    );
    $entradas = filter_input_array(INPUT_POST, $filtros);
    $name = false;
    $desc = false;
    $img = false;
    if (isset($_POST['grupoDesc'])) {
        if (validarString($entradas['grupoDesc'], 300)) {
            $desc = $entradas['grupoDesc'];
        }
    }
    if (isset($_POST['grupoName'])) {
        if (validarString($entradas['grupoName'], 140)) {
            $name = $entradas['grupoName'];
        }
    }
    if (isset($_FILES['grupoImg'])) {
        if (validarImg($_FILES['grupoImg'])) {
            $img = $_FILES['grupoImg'];
        }
    }
    if ($name != false || $desc != false || $img != false) {
        $test = modificarGrupo($_SESSION['grupo'][0], $name, $desc, $img);
        if ($test) {
            saveToDisk($img);
        }
        return true;
    } else {
//Mostrar campos invalidos o advertencia para rellenar
        return false;
    }
}

//Tratamineto formulario EliminarGrupo
function trataEliminarGrupo() {
    $bol = eliminarGrupo($_SESSION['grupo'][0]);
    unset($_SESSION['grupo']);
    return $bol;
}

//Tratamiento formulario crear grupo
function trataCrearGrupo() {
    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'grupoName' => FILTER_SANITIZE_STRING,
        'grupoDesc' => FILTER_SANITIZE_STRING
    );
    $entradas = filter_input_array(INPUT_POST, $filtros);
    $name = false;
    $desc = false;
    $img = false;
    if (validarString($entradas['grupoDesc'], 300) && validarString($entradas['grupoName'], 140) && validarImg($_FILES['grupoImg'])) {
        $name = $entradas['grupoName'];
        $desc = $entradas['grupoDesc'];
        $img = $_FILES['grupoImg'];
        $test = crearGrupo($name, $desc, $img);
        if ($test) {
            saveToDisk($img);
        }
        return true;
    }
    return false;
}

?>