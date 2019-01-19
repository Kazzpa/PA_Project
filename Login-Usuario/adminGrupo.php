<?php
session_start();
?>
<!DOCTYPE html>
<!-- WIP-->
<html lang="es">
    <head>
        <title>Panel admin grupo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include 'stylesheets.php'; ?>

        <style>
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }

            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {height: 450px}

            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #f1f1f1;
                height: 100%;
            }

            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
            }

            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            }
        </style>
    </head>
    <body>
        <?php
        session_start();
        include 'grupo_db.php';
        $limite = 5 * 1024 * 1024; #5MB limite imagen
        //imprime un formulario para buscar/seleccionar un grupo

        function formGrupo() {
            echo '
            <form action="" method="POST">
                <div class="form-group">
                    <b>Buscar grupo a tratar:<br/>
                    Nombre: </b><input type="text" class="form-control" name="grupo" placeholder="Nombre grupo">
                    <input type="submit" class="btn btn-primary" name="BuscarGrupo" value="Buscar">
                </div>
            </form>';
        }

        //Comprueba si existe el grupo especificado
        function modGrupo() {
            echo '<form action="" method="POST" enctype="multipart/form-data">
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
                echo '<img src="' . $_SESSION['grupo'][3] . '" alt="imagen de ' . $_SESSION['grupo'][1] . 'width="10%"></img><br/>';
            }
            echo'<input type="file" class="form-control" name="grupoImg" placeholder="ruta imagen"><br/>
                    </div>
                    <input type="submit" class="btn btn-primary" name="ModGrupo" value="Modificar">
                    <input type="submit" class="btn btn-danger" name="EliminarGrupo" value="Eliminar">
            </form>';
        }

        function formCrearGrupo() {
            echo '<form action="" method="POST" enctype="multipart/form-data">
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
                </div> 
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
                if (validarDesc($entradas['grupoDesc'])) {
                    $desc = $entradas['grupoDesc'];
                }
            }
            if (isset($_POST['grupoName'])) {
                if (validarName($entradas['grupoName'])) {
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
            if (validarDesc($entradas['grupoDesc']) && validarName($entradas['grupoName']) && validarImg($_FILES['grupoImg'])) {
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

        //---------COMPROBACIONES COMUNES---------------
        //comprueba que el nombre empiece por letras, pueda tener caraceters y maximo tamaño 140
        function validarName($name) {
            //regexp normal /^[0-9a-zñáéíóúü]+(.*|\s)*$/
            return preg_match("/^[[:alnum:]]+/", $name) && strlen($name) < 140 && !empty(trim($name));
        }

        //comprueba que la descripcion empiece por letras, pueda tener caraceters y maximo tamaño 300
        function validarDesc($desc) {
            return preg_match("/^[0-9a-zñáéíóúü]+(.*|\s)*$/", $desc) && strlen($desc) < 300 && !empty(trim($desc));
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

        function limiteTamanyo($archivo, $limite) {
            $bool = False;
            if (isset($archivo)) {
                if ($archivo["size"] <= $limite) {
                    $bool = True;
                }
            }
            return $bool;
        }

        //guarda en ficheros la foto
        function saveToDisk($archivo) {
            $bol = False;
            if (file_exists($archivo['tmp_name'])) {
                if (!file_exists($GLOBALS['rutaImg'])) {
                    mkdir($GLOBALS['rutaImg']);
                }
                if (move_uploaded_file($archivo['tmp_name'], $GLOBALS['rutaImg'] . $archivo['name'])) {
                    $bol = True;
                }
            }
            return $bol;
        }

        $bol = compruebaEnviado();
        ?>
        <!-- Barra de navegacion superior -->
        <nav class="navbar navbar-inverse">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>                        
                    </button>
                    <a class="navbar-brand" href="index.html">Logo</a>
                </div>
                <div class="collapse navbar-collapse" id="myNavbar">
                    <ul class="nav navbar-nav">
                        <li class="active"><a href="#">Home</a></li>
                        <li><a href="adminGrupo.php">Meets</a></li>
                        <li><a href="Grupo.php">Projects</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="login.html"><span class="glyphicon glyphicon-log-in"></span> Login</a></li>
                    </ul>
                </div>
            </div>
        </nav>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                    <!-- Barra navegacion izquierda -->
                    <p><a href="#">Link</a></p>
                    <p><a href="#">Link</a></p>
                    <p><a href="#">Link</a></p>
                </div>
                <div class="col-sm-8 text-center"> 
                    <!-- Parte central -->
<?php
if (!$bol) {
    formGrupo();
    echo "<br/>Panel creacion: </br>";
    formCrearGrupo();
} else {
    modGrupo();
}
?>
                </div>
                <div class="col-sm-2 sidenav">
                    <!-- Parte derecha -->
                </div>
            </div>
        </div>

        <footer class="container-fluid text-center">
            <!-- Footer -->
            Icons made by <a href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
        </footer>

    </body>
</html>