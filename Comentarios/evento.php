<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<?php
session_start();
?>
<html>
    <head>
        <title>Evento</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/hojaestilo.css"/> <!--Esta es una forma de hacer la otra es <head> <style type="text/css"> pero es menos recomendable-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <script type="text/javascript" src="js/jquery-3.3.1.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                mostrarTabla();
                editClick = false;

                function mostrarTabla() {
                    $.ajax({
                        type: "POST",
                        url: "mostrarMensajes.php",
                        cache: false,
                        success: function (data) {
                            console.log(data);
                            data = JSON.parse(data);
                            var tbodyComments = document.getElementById("tbodyComments");
                            var table = document.getElementById("tableComments");
                            //si la tabla ya estaba creada, se borra
                            if (tbodyComments !== null) {
                                table.removeChild(tbodyComments);
                            }
                            var tbodyComments = document.createElement('tbody');
                            tbodyComments.id = "tbodyComments";
                            table.appendChild(tbodyComments);

                            for (var i = 0; i < data.length; i++) {

                                var tr = document.createElement('tr');
                                tr.id = "tr" + i;
                                tbodyComments.appendChild(tr);
                                var td0 = document.createElement('td');
                                var img = document.createElement('i');
                                img.src = "imagenUsuario.png";
                                td0.appendChild(img);
                                tr.appendChild(td0);

                                var td1 = document.createElement('td');
                                var ul = document.createElement('ul');
                                ul.style = "list-style:none";
                                var li0 = document.createElement('li');
                                var li0Text = document.createTextNode(data[i][1] + " - " + data[i][3]);
                                li0.appendChild(li0Text);
                                ul.appendChild(li0);

                                var li1 = document.createElement('li');
                                li1.id = "li" + data[i][0];
                                var li1Text = document.createTextNode(data[i][4]);
                                li1.appendChild(li1Text);
                                ul.appendChild(li1);

                                td1.appendChild(ul);
                                tr.appendChild(td1);

                                if (data[i][1] === "<?php echo $_SESSION['username']; ?>") {
                                    var td2 = document.createElement('td');
                                    var div1 = document.createElement('div');
                                    div1.className += "edit";
                                    div1.id = data[i][0];
                                    var text1 = document.createTextNode("Editar");
                                    div1.appendChild(text1);

                                    var div2 = document.createElement('div');
                                    div2.className += "delete";
                                    div2.id = data[i][0];
                                    var text2 = document.createTextNode("Eliminar");
                                    div2.appendChild(text2);

                                    td2.appendChild(div1);
                                    td2.appendChild(div2);

                                    tr.appendChild(td2);
                                }
                            }
                        }
                    });
                }

                $(document).on("click", ".delete", function () {
                    if (confirm("¿Seguro que quieres eliminar este comentario?")) {
                        var comment = $(this).attr('id');
                        var DATA = 'comment=' + comment;
                        $.ajax({
                            type: "POST",
                            url: "deleteMessage.php",
                            data: DATA,
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
                        $("#li" + comment).replaceWith('<textarea id="textArea' + comment + '">' + $("#li" + comment).text() + '</textarea>');
                        $(document).on("click", ".clicked#" + comment, function () {
                            var newComment = $("#textArea" + comment).val();
                            $.ajax({
                                type: "POST",
                                url: "editMessage.php",
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
            });
        </script>
    </head>
    <body>
        <div id="header">
            <header>
                <div id="logo">
                    <h1>Infinity</h1>
                </div>
            </header>
            <div id="header-nav">
                <a href="index.php" class="link"><i class="material-icons">home</i></a>
                <a href="evento.php" class="link"><i class="material-icons">event</i></a>
                <a href="login.php" class="link"><i class="material-icons">account_circle</i></a>
            </div>
        </div>       
        <h2>Comenta sobre el evento</h2>
        <!-- publicar comentario -->
        <form action="mensajeProcesamiento.php" method = "post">
            <textarea name="msgTextArea" placeholder="¿Qué opinas?" required></textarea>
            <input type="submit" value="Publicar" name="publishComment" />
        </form>

        <table id="tableComments">
            <thead>
                <tr>
                    <th>Comentarios</th>
                </tr>
            </thead>
            <tbody id="tbodyComments">
            </tbody>
        </table>
    </body>
</html>
