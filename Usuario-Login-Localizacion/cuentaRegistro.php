<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
    </head>
    <body>
        <?php include("header.php") ?>
        <form action = "cuentaRegistroProcesamiento.php" method = "post" enctype="multipart/form-data">
            Nombre y primer apellido: <input type = "text" name = "nombre" required/><br />
            Usuario: <input type = "text" name = "username" required/><br />
            Email: <input type = "email" name = "email" required /><br />
            Password: <input type = "password" name = "password" required /><br />
            Foto: <input type="file" name="imagen" /> <br />
            <input type = "submit" value="Registro" name = "registroProcesamiento" />
        </form>
    </body>
</html>

<?php
if (isset($_SESSION["rechazado"])) {
    echo "Error al registrarse, es posible que el usuario que intenta crear ya exista";
}

