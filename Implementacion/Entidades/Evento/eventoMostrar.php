<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();

function printSuscritos($suscritos) {
    $str = "";
    if (sizeof($suscritos) > 0) {
        $str = '<table class="table"><thead><tr>'
                . '<th>Algunos usuarios con reserva:</th></tr></thead><tbody>';


        for ($i = 0; $i < sizeof($suscritos); $i++) {
            $str .= '<tr>';
            $str .= '<td>' . $suscritos[$i]['username'] . '</td></tr > ';
        }
        $str .= '</tbody></table>';
    } else {
        $str = '<table class="table"><thead><tr>'
                . '<th>Algunos usuarios con reserva:</th></tr></thead><tbody>';
        $str .= '<tr><td> No hay personas apuntadas ¡Animate y apuntate! </td></tr > ';
        $str .= '</tbody></table>';
    }
    return $str;
}
?>

<html>
    <head>
        <title>Evento Mostrar</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("../stylesheets.php"); ?>
        <!--Importes MAPS -->
        <link rel="stylesheet" type="text/css" href="../../css/maps.css"/>
    </head>
    <body>
        <?php
        include("../header.php");
        $evento_id = $_GET['id'];

        include("../../conexion.php");
        include("../Grupo/adminGrupo.php");

        $consulta = "SELECT * FROM `events` WHERE id = '$evento_id'"; //consulta SQL para obtener el usuario, luego comprobamos la password

        $resultado = mysqli_query($con, $consulta);

        if (!(mysqli_num_rows($resultado)) == 0) {   //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
            $fila = mysqli_fetch_array($resultado);

            $nombreEvento = $fila['name'];
            $fechaCreacion = $fila['date_creation'];
            $fechaCelebracion = $fila['date_celebration'];
            $creador = $fila['host'];
            $descripcion = $fila['description'];
            $evento_id = $fila['id'];
            $rutaimagen = $fila['rutaimagen'];
            $grupoEvento = $fila['group_id'];
            $grupoInfo = false;
            if ($grupoEvento != 0) {
                $consulta = 'SELECT * FROM grupo WHERE grupo.id = "' . $grupoEvento . '"';
                $resultado = mysqli_query($con, $consulta);
                if ($resultado) {
                    if (!(mysqli_num_rows($resultado)) == 0) {
                        if ($row = mysqli_fetch_array($resultado)) {
                            $i = 0;
                            while ($i < 4) {
                                $grupoInfo[] = $row[$i];
                                $i++;
                            }
                        }
                    }
                }
            }
            ?>

            <!--Google Maps API-->
            <iframe
                id="map"
                height="30%"
                width="100%"
                frameborder="0" style="margin-top:1em"
                allowfullscreen>
            </iframe>
            <div class="container-fluid text-center">    
                <div class="row content">
                    <div class="col-sm-2 sidenav">
                    </div>
                    <div class="col-sm-8 text-center well" style="background-color: black; color:white">  <!--text-center, text-left... se puede cambiar, well le da el toque de redondez a los bordes-->
                        <?php
                        echo "<h1 style=' color:white;
                            '>$nombreEvento</h1>";
                        if (isset($_SESSION["login"])) {    //Si el usuario esta logado podra apuntarse al evento
                            //Hacemos una consulta para saber si ya esta suscrito o no al evento
                            $user = $_SESSION['username'];
                            $consulta = "SELECT * FROM `reserva` WHERE id_evento = '$evento_id' AND username= '$user'"; //consulta SQL para obtener el usuario, luego comprobamos la password

                            $resultado = mysqli_query($con, $consulta);

                            if (!$resultado || !(mysqli_num_rows($resultado)) == 0) {  //Si el usuario esta apuntado le damos la oportunidad de quitarse
                                ?>
                                <form action="reservaBaja.php" method = "post">
                                    <input type=' submit' value="Cancelar Reserva" class='btnSubmit' style='font-weight: 600;
                                           color: #0062cc;background-color: #fff;' /><br />
                                           <?php
                                           echo "<input type='hidden' name='user' value=$user>
                                <input type='hidden' name='event_id' value=$evento_id>";
                                           $_SESSION['webRedirect'] = basename($_SERVER['PHP_SELF']);
                                           ?>
                                </form>
                                <?php
                            } else {   //Si el usuario no esta apuntado le damos la opcion de hacerlo
                                ?>
                                <form action="reservaAlta.php" method = "post">
                                    <input type='submit' value="Reservar" class='btnSubmit' style='font-weight: 600;color: #0062cc;background-color: #fff;' /><br />
                                    <?php
                                    echo "<input type='hidden' name='user' value=$user>
                                <input type='hidden' name='event_id' value=$evento_id>";
                                    $_SESSION['webRedirect'] = basename($_SERVER['PHP_SELF']);
                                    ?>
                                </form>
                                <?php
                            }
                        }
                        ?>
                        <div class="col-md-12">
                            <?php
                            echo "<img class='col-md-9' src='$rutaimagen' alt='imagen del evento' class='img-responsive' style='width:60%;'><br />";


                            $consulta = "SELECT * FROM `reserva` WHERE id_evento = '$evento_id' ORDER BY RAND() LIMIT 5"; //consulta SQL para obtener el usuario, luego comprobamos la password

                            $resultado = mysqli_query($con, $consulta);

                            mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
                            $filareserva = Array();
                            ?>
                            <div class='col-md-3'>
                                <?php
                                if ($resultado) {
                                    if (!(mysqli_num_rows($resultado)) == 0) {
                                        $i = 0;
                                        //Retiramos las filas de la consulta realizada
                                        while ($auxiliar = mysqli_fetch_array($resultado)) {
                                            //Este auxiliar es para evitar que se meta la ultima iteracion vacia
                                            $filareserva[$i] = $auxiliar;
                                            $i++;
                                        }
                                    }
                                }
                                echo printSuscritos($filareserva);
                                ?>
                            </div>
                        </div>
                        <?php
                        echo "Creado el dia: $fechaCreacion<br />";
                        echo "Su host sera: $creador y se celebrara el dia: $fechaCelebracion<br />";
                        echo "Su host cree que necesitara saber lo siguiente: $descripcion <br/>";
                        if ($grupoEvento != 0) {
                            echo (printCardGrupo($grupoInfo));
                        }
                        ?>
                        <!--tabla de comentarios-->
                        <div id="comentsWapos" style="background-color: white; color:black;">
                            <?php if (isset($_SESSION['username'])) { ?>
                                <h3>Comenta sobre el evento</h3>
                                <form id="loginForm" action="../Comentario/mensajeProcesamiento.php?id=<?php echo $evento_id; ?>" method = "post">
                                    <textarea name="msgTextArea" id="commentTextArea" placeholder="¿Qué opinas?" required></textarea>
                                    <p class="caracteres_disponibles"></p>
                                    <input type="submit" value="Publicar" name="publishComment" />
                                </form>

                            <?php } ?>
                            <h2>Comentarios</h2>
                            <table id="tableComments" style="margin: auto;">
                                <tbody id="tbodyComments">
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-sm-2 sidenav">
                    </div>
                </div>
            </div> 
            <?php
        } else {
            mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
            ?>
            <p style="text-align: center;">La pagina a la que intenta acceder no existe</p>
            <?php
        }
        ?>
        <!--
        -----------------------------------------------------
        Google maps API
        -----------------------------------------------------
        -->
        <script type="text/javascript">
            function initMap() {
                downloadUrl('../Localizacion/localizacionMostrar.php?id=<?php echo $evento_id; ?>', function (data) {
                    var map = document.getElementById('map');
                    var xml = data.responseXML;
                    var markers = xml.documentElement.getElementsByTagName('marker');
                    if (markers.length === 0) {
                        document.body.removeChild(map);
                        var header = document.getElementById('header-top');
                        var aviso = document.createElement('div');
                        aviso.className += "text-center well";
                        aviso.appendChild(document.createTextNode("Este evento no tiene una localización asignada, probablemente sea online. Contacte con el host para más información."));
                        header.after(aviso);
                    }

                    Array.prototype.forEach.call(markers, function (markerElem) {
                        console.log(markerElem);
                        map.src = "https://www.google.com/maps/embed/v1/place?key=AIzaSyCACpnp7KaVFiuYEfwaxiKS7OCgw0mQqcA&q=" + encodeURIComponent(markerElem.getAttribute('name')) + "," + encodeURIComponent(markerElem.getAttribute('address'));
                    });
                });
            }

            function downloadUrl(url, callback) {
                var request = window.ActiveXObject ?
                        new ActiveXObject('Microsoft.XMLHTTP') :
                        new XMLHttpRequest;

                request.onreadystatechange = function () {
                    if (request.readyState == 4) {
                        request.onreadystatechange = doNothing;
                        callback(request, request.status);
                    }
                };

                request.open('GET', url, true);
                request.send(null);
            }

            function doNothing() {}

        </script>
        <!--Declaracion del google Maps-->
        <?php include("../Localizacion/mapsScript.php"); ?>
        <!--
        -----------------------------------------------------
        Tabla de comentarios
        -----------------------------------------------------
        -->
        <script type="text/javascript">
            $(document).ready(function () {
                mostrarTabla();
                editClick = false;

                function mostrarTabla() {
                    $.ajax({
                        type: "POST",
                        url: "../Comentario/mensajeMostrar.php?id=<?php echo $_GET['id']; ?>",
                        cache: false,
                        success: function (data) {
                            console.log(data);
                            data = JSON.parse(data);
                            /*
                             * FORMATO DE DATA:
                             * $data = ['posts' => $posts, 'imagenes' => $fila_imagen_format];
                             * donde:
                             *      $fila_posts contiene todos los datos del post
                             *      $fila_imagen_format contiene en un array asociativo 
                             *      username => rutaImagen los datos de cada usuario participante en la conversacion
                             */


                            var tbodyComments = document.getElementById("tbodyComments");
                            var table = document.getElementById("tableComments");
                            //si la tabla ya estaba creada, se borra
                            if (tbodyComments !== null) {
                                table.removeChild(tbodyComments);
                            }
                            //y se vuelve a crear de nuevo con los datos actualizados
                            var tbodyComments = document.createElement('tbody');
                            tbodyComments.id = "tbodyComments";
                            table.appendChild(tbodyComments);

                            for (var i = 0; i < data['posts'].length; i++) {

                                var tr = document.createElement('tr');
                                tr.id = "tr" + i;
                                tbodyComments.appendChild(tr);
                                var td0 = document.createElement('td');
                                td0.style = "width:10%;";
                                var img = document.createElement('img');

                                //obtenemos cada imagen de usuario
                                var name = data['posts'][i]['postedBy'];
                                console.log(name);
                                img.src = "../Usuario/" + data['imagenes'][data['posts'][i]['postedBy']];
                                img.style = "width:50%;";
                                img.alt = "imagen de usuario";
                                td0.appendChild(img);
                                tr.appendChild(td0);

                                var td1 = document.createElement('td');
                                td1.style = "text-align:left;border-bottom:1px solid lightgrey;";
                                var ul = document.createElement('ul');
                                ul.style = "list-style:none";
                                var li0 = document.createElement('li');
                                var negrita = document.createElement('b');
                                negrita.appendChild(document.createTextNode(data['posts'][i]['postedBy']));
                                var li0Text = document.createTextNode(" - " + data['posts'][i]['postedDate']);
                                li0.appendChild(negrita);
                                li0.appendChild(li0Text);
                                ul.appendChild(li0);

                                var li1 = document.createElement('li');
                                li1.id = "li" + data['posts'][i]['id'];
                                var li1Text = document.createTextNode(data['posts'][i]['message']);
                                li1.appendChild(li1Text);
                                ul.appendChild(li1);

                                td1.appendChild(ul);
                                tr.appendChild(td1);

                                var td2 = document.createElement('td');
                                td2.style = "text-align:left;";
                                //si el usuario tiene la sesion iniciada, podra modificar sus comentarios
                                if (data['posts'][i]['postedBy'] === "<?php
        if (isset($_SESSION['username']))
            echo $_SESSION['username'];
        else
            echo '';
        ?>") {

                                    var div1 = document.createElement('div');
                                    div1.className += "edit";
                                    div1.id = data['posts'][i]['id'];
                                    var text1 = document.createTextNode("Editar");
                                    div1.appendChild(text1);

                                    var div2 = document.createElement('div');
                                    div2.className += "delete";
                                    div2.id = data['posts'][i]['id'];
                                    var text2 = document.createTextNode("Eliminar");
                                    div2.appendChild(text2);

                                    td2.appendChild(div1);
                                    td2.appendChild(div2);
                                }
                                tr.appendChild(td2);
                            }
                        }
                    });
                }

                $(document).on("click", ".delete", function () {
                    if (confirm("¿Seguro que quieres eliminar este comentario?")) {
                        var comment = $(this).attr('id');
                        $.ajax({
                            type: "POST",
                            url: "../Comentario/mensajeEliminar.php",
                            data: {"comment": comment},
                            cache: false,
                            success: function (data) {
                                mostrarTabla();
                            }
                        });
                    }
                });

                $(document).on("click", ".edit", function () {
                    if (editClick === false) {
                        editClick = true;
                        $(this).addClass("clicked");
                        var comment = $(this).attr('id');
                        $("#li" + comment).replaceWith('<textarea id="textArea' + comment + '">' + $("#li" + comment).text() + '</textarea><p id="caracteres_disponibles"></p>');
                        var button = document.createElement('input');
                        button.type = "submit";
                        button.id = "editButton" + comment;
                        button.value = "Editar";
                        $("#textArea" + comment).after(button);
                        $("#editButton" + comment).before("<br/>");
                        validarCaracteres($('#caracteres_disponibles'), $('textarea'));

                        $(document).on("click", "#editButton" + comment, function () {
                            var newComment = $("#textArea" + comment).val();
                            $.ajax({
                                type: "POST",
                                url: "../Comentario/mensajeModificar.php",
                                data: {"comment": comment, "newComment": newComment},
                                cache: false,
                                success: function (data) {
                                    mostrarTabla();
                                }
                            });
                            editClick = false;
                        });

                    }
                });
                validarCaracteres($('.caracteres_disponibles'), $('#commentTextArea'));
                function validarCaracteres(caracteres_disponibles, texto) {
                    caracteres_disponibles.text('Máximo 500 caracteres por mensaje.');
                    texto.keyup(function () {
                        var max = 500;
                        var len = $(this).val().length;
                        if (len == 0) {
                            caracteres_disponibles.text('Máximo 500 caracteres por mensaje.');
                            caracteres_disponibles.addClass('red');
                        } else if (len >= max) {
                            caracteres_disponibles.text('Máximo 500 caracteres por mensaje.');
                            caracteres_disponibles.addClass('red');
                            this.value = this.value.substring(0, max);
                        } else {
                            var ch = max - len;
                            caracteres_disponibles.text(ch + ' caracteres');
                            caracteres_disponibles.removeClass('red');
                        }
                    });
                }
            });
        </script>
        <!--Plugin para el text area de los comentarios-->
        <script type="text/javascript" src="../../js/resize-textarea.js"></script>
    </body>
</html>