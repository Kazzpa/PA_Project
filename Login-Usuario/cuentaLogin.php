<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->

<?php
session_start();

if (!isset($_SESSION["login"])) {    //Si no hemos hecho login lo mostramos
    ?>
    <html>
        <head>
            <title>Login</title>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="css/hojaestilo.css"/> <!--Esta es una forma de hacer la otra es <head> <style type="text/css"> pero es menos recomendable-->
            <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
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
                    <a href="form.html" class="link"><i class="material-icons">event</i></a>
                    <a href="login.php" class="link"><i class="material-icons">account_circle</i></a>
                </div>
            </div>       
            <form action = "cuentaLoginProcesamiento.php" method = "post">
                Usuario: <input type = "text" name = "username" required/><br /> <!--Preguntar por correo electronico en vez de usuario-->
                Password: <input type = "password" name = "password" required /> <br />
                <input type = "submit" value="Enviar" name = "login" />
            </form>
            <form action = "cuentaRegistro.php" method = "post">
                Si no esta registrado <input type="submit" value="Registrese" name="registro" /> <!--Boton que al pulsar te redirecciona a registro-->
            </form>
            <?php
//En vez de un html como ponia en la practica hemos introducido un php para poder avisar del error de logueo
            if (isset($_SESSION["fallido"])) {
                echo "Error al logearse";
            }
            if (isset($_SESSION["exito"])) {
                unset($_SESSION["exito"]);
                echo "Se ha registrado correctamente, pruebe a logearse con la cuenta creada";
            }
        } else {    //Si ya estamos con la sesion iniciada le permitimos hacer cambios en los datos
            ?>
            <p>Bienvenido, sus datos son los siguientes: </p>
            <?php
            ?>
            <p> Si quiere cambiar un dato seleccionelo del campo a continuacion e introduzca el nuevo valor: </p>
            <form action = "cuentaModificar.php" method = "post">
                <select name="select">
                    <option value="email"> Email</option>
                    <option value="password"> Password</option>
                </select>
                <input type="text" value="" name="campoTexto">
                <input type="submit" value="Modificar Datos" name="registro" /> <!--Boton que al pulsar te redirecciona a registro-->
            </form>

            <form action = "cuentaEliminar.php" method = "post">
                <input type="submit" value="Eliminar cuenta" name="registro" /> <!--Eliminamos la cuenta del usuario si asi lo pide-->
            </form>
            <?php
        }
        ?>
    </body>
</html>
