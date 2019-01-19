<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Visualizacion grupo WIP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include 'stylesheets.php';
        ?>
    </head>
    <body>
        <!-- Por ahora funciona la preview del grupo y los usuarios suscritos -->
        <?php
        include 'header.php';
        include 'grupo_db.php';
        include 'validation.php';
        include 'logros_db.php';

        function printGrupo($group) {
            $str = "<h1>" . $group[1] . "</h1>"
                    . "<h4>" . $group[2] . "</h4>";
            if (file_exists($group[3])) {
                $str = $str . '<img src="' . $group[3] . '" alt="imagen de ' . $group[1] . '"></img>';
            }
            return $str;
        }

        //Saca un formulario para buscar un grupo en caso de no encontrarlo
        function printform() {
            return '<form method = "GET" action = "#">
                            <div class="form-group form-control-lg">
                        <input type = "text" class="form-control" name = "grupo" placeholder = "Introduzca el nombre del grupo que busca">
                        <input type = "submit" class="btn btn-primary" value="Buscar grupo">
                        </div>
                        </form>';
        }

        $bol = isset($_GET['grupo']) && $_GET['grupo'] != '';
        $bol2 = false;
        if ($bol) {
            $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                'grupo' => FILTER_SANITIZE_STRING
            );
            $entradas = filter_input_array(INPUT_GET, $filtros);
            $groupInfo = getGroup($entradas['grupo']);
            $info2 = false;
            //$info2 = getUsersSubs($entradas['grupo']);
            //Grupo valido pero no registrado
            if (!$groupInfo) {
                $bol = false;
            }
            if ($info2) {
                $bol2 = true;
            }
        }
        ?>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                </div>
                <div class="col-sm-8 text-center well" >
                    <?php
                    //Comprobamos que haya un grupo registrado
                    if ($bol) {
                        echo (printGrupo($groupInfo));
                    } else {
                        if (isset($_GET['grupo']) && $_GET['grupo'] != '') {
                            echo "<h4 class='alert alert-warning' width='30%'>No encontrado el grupo</h2>";
                        }
                        echo (printform());
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
                            if ($bol2) {
                                for ($i = 0; $i < sizeof($info2); $i++) {
                                    echo'<tr><td>';
                                    if ($info2[$i][1] > 0) {
                                        echo '[MOD]';
                                    }
                                    echo '</td><td>' . $info2[$i][0] . '</td></tr>';
                                }
                            }
                            ?>
                        </tbody>
                    </table>
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