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
        <title>Registro</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="css/hojaestilo.css"/> <!--Esta es una forma de hacer la otra es <head> <style type="text/css"> pero es menos recomendable-->
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>
    <body>
        <h1> Infinity </h1>
        <h2> Registro</h2>
        <div id="header-nav">
            <a href="index.php" class="link"><i class="material-icons">home</i></a>
            <a href="form.html" class="link"><i class="material-icons">event</i></a>
            <a href="login.php" class="link"><i class="material-icons">account_circle</i></a>
        </div>
        <form action = "cuentaRegistroProcesamiento.php" method = "post">
            Nombre: <input type = "text" name = "nombre" required/><br />
            Usuario: <input type = "text" name = "username" required/><br />
            Email: <input type = "email" name = "email" required /><br />
            Password: <input type = "password" name = "password" required /><br />
            <input type = "submit" value="Registro" name = "registroProcesamiento" />
        </form>
    </body>
</html>

<?php
if (isset($_SESSION["rechazado"])) {
    echo "Error al registrarse, es posible que el usuario que intenta crear ya exista";
}

