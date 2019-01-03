<!DOCTYPE html>
<!-- WIP-->
<html lang="en">
    <head>
        <title>Panel admin grupo</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
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

        //imprime un formulario para buscar/seleccionar un grupo
        function formGrupo() {
            echo '
            <form action="" method="POST">
                <div class="form-control">
                    Buscar grupo a tratar:<br/>
                    Nombre:<input type="text" name="grupo" placeholder="Nombre grupo">
                    <input type="submit" name="BuscarGrupo" value="Buscar">
                </div>
            </form>';
        }

        //Comprueba si existe el grupo especificado
        function mostrarGrupo() {
            echo '<form action="" method="POST">
                <div class="form-control">
                    Modificar Nombre: <i>"' . utf8_decode($_SESSION['grupo'][1]) . '"</i><br/>
                    <input type="text" name="grupoName" placeholder=""><br/>
                    Modificar descripcion: 
                    <br/><i>"' . utf8_decode($_SESSION['grupo'][2]) . '" </i><br/>
                    <input type="text" name="grupoDesc" placeholder="Descripcion"><br/>
                    Modificar Imagen: <br/>
                    <img src="' . $_SESSION['grupo'][3] . '" alt="imagen de ' . $_SESSION['grupo'][1] . '" width="10%"></img><br/>
                    <input type="file" name="grupoImg" placeholder="ruta imagen"><br/>
                    <input type="submit" name="ModGrupo" value="Modificar">
                </div>
            </form>';
        }

        //Devuelve falso si no se ha enviado, o si no esta el grupo registrado
        //si esta registrado, lo guarda en una variable de sesion
        function compruebaEnviado() {
            if (isset($_POST['grupo']) || !isset($_SESSION['grupo'])) {
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
            } else if (isset($_POST['ModGrupo'])) {
                if (isset($_POST['grupoName']) && isset($_POST['grupoDesc']) && isset($_FILES['grupoImg'])) {
                    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                        'grupoName' => FILTER_SANITIZE_STRING,
                        'grupoDesc' => FILTER_SANITIZE_STRING
                    );
                    $entradas = filter_input_array(INPUT_POST, $filtros);
                    if (validarDesc($entradas['grupoDesc'])) {
                        if (validarName($entradas['grupoName'])) {
                            if (validarImg($_FILES['grupoImg'])) {
                                
                            }
                        }
                    }
                }
            }
        }

        //comprueba que el nombre empiece por letras, pueda tener caraceters y maximo tamaño 140
        function validarName($name) {
            echo "<br/>" . $name . "funciona: " . preg_match("^[0-9a-zñáéíóúü]+(.*|\s)*$", $name) . " <br/>";
            return preg_match("^[0-9a-zñáéíóúü]+(.*|\s)*$", $name) && sizeof($name) < 140;
        }

        //comprueba que la descripcion empiece por letras, pueda tener caraceters y maximo tamaño 300
        function validarDesc($desc) {
            echo "<br/>" . $desc . "funciona: " . preg_match("^[0-9a-zñáéíóúü]+(.*|\s)*$", $desc) . " <br/>";
            return preg_match("^[0-9a-zñáéíóúü]+(.*|\s)*$", $desc) && sizeof($desc) < 300;
        }

        $limite = 5 * 1024 * 1024; #5MB limite imagen

        function validarImg($img) {
            //comprueba si no hubo un error en la subida
            if ($img["error"] > 0 && soloImg($img) && !limiteTamanyo($img, $limite)) {
                guardarFoto($img);
            }
        }

        function soloImg($archivo) {
            $bool = False;
            if (isset($archivo)) {
                if ($archivo["type"] == "image/png" || $archivo["type"] == "image/jpeg") {
                    $bool = True;
                }
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

        function validaForm() {
            
        }

        session_start();
        include 'functions.php';

//DEBUG
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
                        <li><a href="#">Meets</a></li>
                        <li><a href="#">Projects</a></li>
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
                    } else {
                        mostrarGrupo();
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