<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <?php include("stylesheets.php"); ?>
    </head>
    <body>
        <?php
        include("header.php");
        ?>
        <form action = "eventoCreacionProcesamiento.php" method = "post" enctype="multipart/form-data">
            Nombre del evento: <input type = "text" name = "name" required/><br />
            Descripcion: <br/>
            <textarea> rows="4" cols="50" name = "description" required/>Introduzca una breve descripcion sobre el evento a realizar</textarea><br />
            Foto: <input type="file" name="imagen" /> <br />
            <br />
            Fecha de celebracion: <input type = "datetime-local" name = "date-celebration" required /><br />
            <input type = "submit" value="Registro" name = "registroProcesamiento" />
        </form>
    </body>
</html>
