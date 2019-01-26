<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Visualizacion grupo WIP</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?php include 'stylesheets.php';
        ?>
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <link type='text/css' rel='stylesheet' href='css/gallery.css'>
        <link type="text/css" rel="stylesheet" href="css/lightGallery.css" /> 
    </head>
    <body>
        <!-- Por ahora funciona la preview del grupo y los usuarios suscritos -->
        <?php
        include 'header.php';
        include_once 'grupo_db.php';
        include_once 'validation.php';
        include_once 'logros_db.php';
        include_once 'adminGrupo.php';

        function printGrupo($group, $logrosInfo, $suscritos) {
            $str = "<h1>" . $group[1] . '</h1><div class="col-md-12">';
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

        function printGrupos() {
            $str = "";
            $ret = getAllGroups(10);
            for ($i = 0; $i < sizeof($ret); $i++) {
                $str .= printCardGrupo($ret[$i]);
            }
            return $str;
        }

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
        function printform() {
            return '<form method = "GET" action = "#">
                            <div class = "form-group form-control-lg">
            <input type = "text" class = "form-control" name = "grupo" placeholder = "Introduzca el nombre del grupo que busca">
            <input type = "submit" class = "btn btn-primary" value = "Buscar grupo">
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
            $logrosInfo = getGroupLogros($groupInfo[0]);
            $infoSubscribers = false;
            //$info2 = getUsersSubs($entradas['grupo']);
            //Grupo valido pero no registrado
            if (!$groupInfo) {
                $bol = false;
            }
            if ($infoSubscribers) {
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
                        echo (printGrupo($groupInfo, $logrosInfo, $infoSubscribers));
                    } else {
                        if (isset($_GET['grupo']) && $_GET['grupo'] != '') {
                            echo "<h4 class='alert alert-warning' width='30%'>No encontrado el grupo</h2>";
                        }
                        echo (printform());
                        echo (printGrupos());
                    }
                    ?>


                    <!--GALERIA DEL GRUPO-->
                        <?php if ($bol) { ?>
                        <div class="container">
                        <?php include('fotoMostrar.php'); ?>
                        </div>
                    <?php } ?>
                    <!-- SUBIDA DE FOTOS, SOLO EL ADMINISTRADOR DEL GRUPO-->
                    <?php
                    if (isset($_SESSION['username']) && isset($_GET['grupo'])) {
                        include('grupoIsAdmin.php');
                        if ($admin) {
                            ?>
                            <h3>Sube una imagen: </h3>
                            <form action = "fotosIncluir.php" method = "post" enctype="multipart/form-data">          
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
                    $("#img" + encabezado).replaceWith('<textarea id="textArea' + encabezado + '" style="color:black;">' + $("#img" + encabezado).text() + '</textarea>');
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
                            url: "fotoModificar.php",
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
                            url: "fotoEliminar.php",
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
        <script src="js/picturefill.min.js"></script>
        <script src="js/lightgallery-all.js"></script>
        <script src="js/jquery.mousewheel.min.js"></script>
    </body>
</html>