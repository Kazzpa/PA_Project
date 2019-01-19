<?php
session_start();
?>
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
        <div class="container login-container">
            <div class="row">
                <div class="col-md-3">  <!--Columnas creadas para centrar, una row tiene 12 filas asi que usamos 3 a la izquierda 6 wur ocupa el registro y 3 a la derecha-->
                </div>
                <div class="col-md-6 login-form-1">
                    <h3>Formulario de registro</h3>
                    <form action = "cuentaRegistroProcesamiento.php" method = "post" enctype="multipart/form-data">
                        <div class="form-group">
                            <input type="text" name="nombre" class="form-control" placeholder="Nombre y Primer apellido" required />
                        </div>
                        <div class="form-group">
                            <input type="text" name="username" class="form-control" placeholder="Username" required />
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" class="form-control" placeholder="E-mail" required />
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" class="form-control" placeholder="Password" required/>
                        </div>
                        <div class="form-group">
                            <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                        </div>
                        <div class="form-group">
                            <input type="submit"  value="Registro" name= "registroProcesamiento" class="btnSubmit" />
                        </div>
                    </form>
                </div>
                <div class="col-md-3">
                </div>
            </div>
        </div>
        <!--
        <form action = "cuentaRegistroProcesamiento.php" method = "post" enctype="multipart/form-data">
            Nombre y primer apellido: <input type = "text" name = "nombre" required/><br />
            Usuario: <input type = "text" name = "username" required/><br />
            Email: <input type = "email" name = "email" required /><br />
            Password: <input type = "password" name = "password" required /><br />
            Foto: <input type="file" name="imagen" /> <br />
            <input type = "submit" value="Registro" name = "registroProcesamiento" />
        </form>-->
    </body>
</html>

<?php
if (isset($_SESSION["rechazado"])) {
    echo "Error al registrarse, es posible que el usuario que intenta crear ya exista";
}

