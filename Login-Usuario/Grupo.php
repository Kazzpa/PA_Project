<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Visualizacion grupo WIP</title>
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
<!-- Por ahora funciona la preview del grupo y los usuarios suscritos -->
        <?php

        function printName($group) {
            return "<h1>" . utf8_decode($group[1]) . "</h1>";
        }

        function printDesc($group) {
            return "<h4>" . utf8_decode($group[2]) . "</h4>";
        }

        function printIMG($group) {
            return '<img src="' . $group[3] . '" alt="imagen de ' . $group[1] . '"></img>';
        }
        //Saca un formulario para buscar un grupo en caso de no encontrarlo
        function printform(){
            echo '<form method = "GET" action = "#">
                            <div class="form-group form-control-lg">
                        <input type = "text" class="form-control" name = "grupo" placeholder = "Introduzca el nombre del grupo que busca">
                        <input type = "submit" class="btn btn-primary" value="Buscar grupo">
                        </div>
                        </form>';
        }

        include 'functions.php';
        session_start();
        $bol = isset($_GET['grupo']) && $_GET['grupo'] != '';
        $bol2 = false;
        if ($bol) {
            $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                'grupo' => FILTER_SANITIZE_STRING
            );
            $entradas = filter_input_array(INPUT_GET, $filtros);
            $info = getGroup($entradas['grupo']);
            $info2 = false; 
            //$info2 = getUsersSubs($entradas['grupo']);
            //Grupo valido pero no registrado
            if(!$info){
                $bol = false;
            }
            if($info2){
                $bol2 = true;
            }
        }
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
                    Ultimos eventos
                    <p><a href="#">Link</a></p>
                    <p><a href="#">Link</a></p>
                    <p><a href="#">Link</a></p>
                </div>
                <div class="col-sm-8 text-center"> 
                    <?php
                    //Comprobamos que haya un grupo registrado
                    if ($bol) {
                        echo (printName($info));
                        echo (printIMG($info));
                        echo (printDesc($info));
                    } else {
                        echo "<h2 class='alert alert-danger' width='30%'>No encontrado el grupo</h2>";
                        printform();
                    }
                    ?>
                </div>
                <div class="col-sm-2 sidenav">
                    <table class="table">
                        <thead>
                            <tr>
                                <th></th>
                                <th>Usuarios suscritos</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            if($bol2){
                                for( $i = 0 ; $i < sizeof($info2);$i++){
                                    echo'<tr><td>';
                                    if($info2[$i][1] >0){
                                        echo '[MOD]';
                                    }
                                    echo '</td><td>'.$info2[$i][0].'</td></tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                    <!-- Parte derecha -->
                </div>
            </div>
        </div>
        
        
        <!-- GALERIA -->
        <a href="fotos.php">GALERIA</a>
        
        
        
        <footer class="container-fluid text-center">
            <!-- Footer -->
            Icons made by <a href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a>
        </footer>

    </body>
</html>