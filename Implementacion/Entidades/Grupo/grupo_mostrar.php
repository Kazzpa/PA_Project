<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Grupo Mostrar<?php
            if (isset($_GET['grupo'])) {
                echo ' - ' . $_GET['grupo'];
            } else {
                echo 's';
            }
            ?></title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include '../stylesheets.php';
        ?>
        <link type='text/css' rel='stylesheet' href='../../css/gallery.css'>
        <link type="text/css" rel="stylesheet" href="../../css/lightGallery.css" /> 
    </head>
    <body>
        <!-- Por ahora funciona la preview del grupo y los usuarios suscritos -->
        <?php
        include '../header.php';
        include_once 'grupo_db.php';
        include_once '../../validation.php';
        include_once '../Logro/logros_db.php';
        include_once 'adminGrupo.php';

        //Mostrar informacion de un grupo
        function printGrupoExpanded($group, $logrosInfo, $suscritos) {
            $str = '<div id="grupo" class="col-md-12"><h1>' . $group[1] . '</h1>';

            if (isset($_SESSION["login"])) {
                //Ahora mismo el boton no hace nada
                $estaSuscrito = isSubbedToGroup($_SESSION['username'], $group[0]);
                $str .= '<form action="" method="GET"><input type="hidden" name="grupo" value="'.$_GET['grupo'].'">';
                if ($estaSuscrito !== false) {
                    $str .= '<input type="submit" name="desuscribir" value="desuscribirse" class="btn btn-secondary"></input>';
                } else {
                    $str .= '<input type="submit" name="suscribirse" value="suscribirse" class="btn btn-primary"></input>';
                }
                $str .= "</form>";
            }
            if (file_exists($group[3])) {
                $str .= '<img class="col-md-9 img-fluid" src="' . $group[3]
                        . '" alt="imagen de ' . $group[1]
                        . '" style="height:auto;max-width: 100%;"></img>';
            }
            $str .= '<div class="col-md-3" >'
                    . printLogros($logrosInfo) . printSuscritos($suscritos)
                    . '</div></div><h4>' . $group[2] . "</h4>";
            return $str;
        }

        //Mostrar cartas de distintos grupos
        function printGrupos() {
            $str = "";
            $offset = "0";
            if (isset($_GET['pag'])) {
                $offset = $_GET['pag'];
            }
            $ret = getAllGroups(4, $offset);
            $numGrupos = getNumGrupos();
            $str .= '<div class="col-sm-12">';
            for ($i = 0; $i < sizeof($ret); $i++) {
                $str .= printCardGrupo($ret[$i]);
            }
            if ($numGrupos > 4) {
                $str .= '</div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            <li>
                            <a href="?pag=';
                if (isset($_GET['pag'])) {
                    $str .= (string) ($_GET['pag'] - 1);
                }
                $str .= '" aria-label="Previous">
                                  <span aria-hidden = "true">&laquo;</span>
                            </a>
                            </li>';
                for ($i = 0; $i < $numGrupos / 4; $i++) {
                    $str .= '<li><a href="?pag=' . $i . '">' . $i . '</a></li>';
                }
                $str .= '<li>
                                <a href = "?pag=';
                if (isset($_GET['pag'])) {
                    $str .= (string) ($_GET['pag'] + 1);
                }
                $str .= '" aria-label = "Next">
                                    <span aria-hidden = "true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
            </nav>';
            }
            return $str;
        }

        //Mostrar tabla de usuarios suscritos
        function printSuscritos($suscritos) {
            $str = "";
            if ($suscritos) {
                $str = '<table class="table"><thead><tr><th></th>'
                        . '<th>Usuarios suscritos</th></tr></thead><tbody>';


                for ($i = 0; $i < sizeof($suscritos); $i++) {
                    $str .= '<tr><td>';
                    if ($suscritos[$i][1] > 0) {
                        $str .= '[MOD]';
                    }
                    $str .= '</td><td>' . $suscritos[$i][0] . '</td></tr > ';
                }
                $str .= '</tbody></table>';
            }
            return $str;
        }

        //  0:nombre_logro 1: icon_path 2:descripcion 3:puntos
        function printLogros($logrosInfo) {
            $str = "";
            if ($logrosInfo !== false) {
                $str .= '<h5>Logros del grupo:</h5>';
                for ($i = 0; $i < sizeof($logrosInfo); $i++) {
                    $str .= '<img src="' . $logrosInfo[$i][1] . '" alt="' . $logrosInfo[$i][0] . '"/>';
                }
            }
            return $str;
        }

        //Saca un formulario para buscar un grupo en caso de no encontrarlo
        function printSelect($grupos) {
            return '<form method =
            "GET" action = "#">
            <div class = "form-group form-control-lg">
            <input type = "text" class = "form-control" name = "grupo" 
            placeholder = "Introduzca el nombre del grupo que busca">
            <input type = "submit" class = "btn btn-primary" value = "Buscar grupo">
            </div>
            </form>';
        }

        //Sacamos el boton para crear un nuevo grupo
        function printCreacion() {
            $str = "";
            if (isset($_SESSION["login"])) {
                $str = '

            <form action = "#" method = "POST"><div class = "form-group form-control-sm"><input type = "submit" ' .
                        'name = "quieroCrear" class = "btn btn-default" value = "Crear Grupo">'
                        . ' </input></div></form>
                    <br />';
            }
            return $str;
        }

        $bol = isset($_GET['grupo']) && $_GET['grupo'] != '';
        if ($bol) {
            $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                'grupo' => FILTER_SANITIZE_STRING
            );
            $entradas = filter_input_array(INPUT_GET, $filtros);
            $groupInfo = getGroup($entradas['grupo']);
            if ($groupInfo !== false) {
                $logrosInfo = getGroupLogros($groupInfo[0]);
                $infoSubscribers = getUsersSubs($entradas['grupo']);
                //Grupo valido pero no registrado
                if (isset($_GET['suscribirse'])) {
                    suscribirseGrupo($_SESSION['username'], $groupInfo[0], false);
                } else if (isset($_GET['desuscribir'])) {
                    deSuscribirseGrupo($_SESSION['username'], $groupInfo[0]);
                }
            } else {
                $bol = false;
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
                        echo (printGrupoExpanded($groupInfo, $logrosInfo, $infoSubscribers));
                    } else {
                        if (isset($_POST['quieroCrear'])) {
                            echo (formCrearGrupo());
                        } else if (isset($_POST['crearGrupo'])) {
                            if (isset($_POST['grupoName']) && isset($_POST['grupoDesc']) && isset($_FILES['grupoImg'])) {
                                $resCrear = trataCrearGrupo();
                                suscribirseGrupo($_SESSION['username'], $resCrear[1], true);
                                if ($resCrear[0]) {
                                    echo "<h4 class='alert alert-success' width='30%'>Creado grupo con exito</h2>";
                                }
                                echo (printCreacion());
                                $select = false;
                                echo (printSelect($select));
                                echo (printGrupos());
                            } else {
                                echo (formCrearGrupo());
                            }
                        } else {
                            if (isset($_GET['grupo']) && $_GET['grupo'] != '') {
                                echo "<h4 class='alert alert-warning' width='30%'>No encontrado el grupo</h2>";
                            }
                            echo (printCreacion());
                            $select = false;
                            echo (printSelect($select));
                            echo (printGrupos());
                        }
                    }
                    ?>


                    <!--GALERIA DEL GRUPO-->
                    <?php if ($bol) { ?>
                        <div class="container">
                            <?php include('../Galeria/fotoMostrar.php'); ?>
                        </div>
                    <?php } ?>
                    <!-- SUBIDA DE FOTOS, SOLO EL ADMINISTRADOR DEL GRUPO-->
                    <?php
                    if (isset($_SESSION['username']) && isset($_GET['grupo'])) {
                        include('grupoIsAdmin.php');
                        if ($admin) {
                            ?>
                            <h3>Sube una imagen: </h3>
                            <form action = "../Galeria/fotosIncluir.php" method = "post" enctype="multipart/form-data">          
                                <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                                <p>Descripci&oacute;n de la imagen:</p>
                                <input type = "text" name = "encabezado" class="form-control-file" />
                                <input type="hidden"  value="<?php echo $_GET['grupo']; ?>" name= "grupoId"  />
                                <input type="submit"  value="Subir" name= "fotosIncluir" class = "brn btn-primary" />
                            </form> 
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <script type="text/javascript">
            $(document).ready(function () {
                $("#lightgallery").lightGallery();
                $(document).on("click", ".edit", function () {

                    $(this).addClass("clicked");
                    var encabezado = $(this).attr('id');
                    $("#img" + encabezado).replaceWith('<textarea id = "textArea' + encabezado + '" style = "color:black;">' + $("#img" + encabezado).text() + '</textarea>');
                    var button = document.createElement('input');
                    button.type = "submit";
                    button.id = "editButton" + encabezado;
                    button.value = "Editar"
                    button.style = "color:black;"
                    $("#textArea" + encabezado).after(button);
                    $("#editButton" + encabezado).before("<br/>");

                    $(document).on("click", "#editButton" + encabezado, function () {
                        var newEncabezado = $("#textArea" + encabezado).val();
                        $.ajax({
                            type: "POST",
                            url: "../Galeria/fotoModificar.php",
                            data: {"encabezado": encabezado, "newEncabezado": newEncabezado},
                            cache: false,
                            success: function (data) {
                                location.reload();
                            }
                        });

                    });
                });
                $(document).on("click", ".delete", function () {
                    if (confirm("¿Seguro que quieres eliminar esta imagen?")) {
                        var foto = $(this).attr('id');
                        $.ajax({
                            type: "POST",
                            url: "../Galeria/fotoEliminar.php",
                            data: {"foto": foto},
                            cache: false,
                            success: function (data) {
                                location.reload();
                            }
                        });
                    }
                });
            });

        </script>
        <script src="../../js/picturefill.min.js"></script>
        <script src="../../js/lightgallery-all.js"></script>
        <script src="../../js/jquery.mousewheel.min.js"></script>
    </body>
</html>