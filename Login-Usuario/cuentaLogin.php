<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
    </head>
    <body> 
        <?php
        include("header.php");
        if (!isset($_SESSION["login"])) {    //Si no hemos hecho login lo mostramos
            ?>  
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
            <p>Datos personales:</p>
            <?php
            $nombre = $_SESSION['name'];
            $email = $_SESSION['email'];
            $fechaRegistro = $_SESSION['date_register'];
            $rutaimagen = $_SESSION['rutaimagen'];

            echo "<img src=$rutaimagen width=5%> <br />";
            echo "<strong>Nombre:</strong> $nombre <br />";
            echo "<strong>Email:</strong> $email <br />";
            echo "<strong>Fecha Registro:</strong> $fechaRegistro <br />";
            ?>
            <p> Si quiere modificar un dato seleccionelo del campo a continuacion e introduzca el nuevo valor: </p>
            <form action = "cuentaModificar.php" method = "post">
                <select name="selectCuentaModificar">
                    <option value="email"> Email</option>
                    <option value="password"> Password</option>
                </select>
                <input type="text" value="" name="campoTexto"><br />
                <input type="submit" value="Modificar Datos" name="registro" /> <!--Boton que al pulsar te redirecciona a registro-->
            </form>
            <br />
            <form action = "cuentaModificar.php" method = "post" enctype="multipart/form-data">
                Si desea cambiar su imagen de perfil: <input type="file" name="imagen" /> <br />
                <input type="submit" value="Modificar Foto" name="modificarFoto" /> <!--Boton que al pulsar te redirecciona a registro-->
            </form>
            <br />
            <form action = "cuentaEliminar.php" method = "post">
                <input type="submit" value="Eliminar cuenta" name="registro" /> <!--Eliminamos la cuenta del usuario si asi lo pide-->
            </form>
            <p>Eventos creados:</p>
            <?php
            $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

            if (!$con) {
                die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
            }

            $username = $_SESSION["username"];
            $consulta = "SELECT * FROM `events` WHERE host = '$username'"; //consulta SQL para obtener el usuario, luego comprobamos la password
            $resultado = mysqli_query($con, $consulta);

            if (mysqli_num_rows($resultado) > 0) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
                $i = 0;
                while ($auxiliar = mysqli_fetch_array($resultado)) { /* Con esto retiramos todas las filas que hayan en la base de datos, como pueden ser muchas
                  hay que ir leyendo fila a fila */
                    $fila[$i] = $auxiliar; //este auxiliar es para evitar que se meta la ultima iteracion vacia
                    $i++;
                }
                ?>
                <p>Eliminaci&oacute;n de evento</p>
                <form action = "eventoEliminar.php" method = "post">
                    <select name='selectEventoEliminar'>
                        <?php
                        for ($i = 0; $i < sizeof($fila); $i++) {
                            $event_id = $fila[$i]['id'];
                            $event_name = $fila[$i]['name'];
                            $event_date = $fila[$i]['date_celebration'];
                            $event_creation = $fila[$i]['date_creation'];
                            echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                        }
                        ?>
                    </select>
                    <input type="submit" value="Eliminar Evento" name="botonEventoEliminar" />
                </form>
                <p>Modificaci&oacute;n de evento</p>
                <form action = "eventoModificar.php" method = "post">
                    <select name='selectEventoModificar'>
                        <?php
                        for ($i = 0; $i < sizeof($fila); $i++) {
                            $event_id = $fila[$i]['id'];
                            $event_name = $fila[$i]['name'];
                            $event_date = $fila[$i]['date_celebration'];
                            $event_creation = $fila[$i]['date_creation'];
                            echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                        }
                        ?>
                    </select>
                    <select name="selectCampoEventoModificar">
                        <option value="name"> Nombre Evento</option>
                        <option value="description"> Descripcion</option>
                    </select>
                    <textarea rows="4" cols="50" name="campoTexto"></textarea>
                    <input type="submit" value="Modificar Evento" name="botonEventoModificar" />
                </form>
                <br />
                <form action = "eventoModificar.php" method = "post" enctype="multipart/form-data">
                    <select name='selectEventoModificar'>
                        <?php
                        for ($i = 0; $i < sizeof($fila); $i++) {
                            $event_id = $fila[$i]['id'];
                            $event_name = $fila[$i]['name'];
                            $event_date = $fila[$i]['date_celebration'];
                            $event_creation = $fila[$i]['date_creation'];
                            echo "<option value='$event_id'>Evento: $event_name, Fecha Celebracion: $event_date</option> ";
                        }
                        ?>
                    </select>
                    Si desea cambiar la imagen del evento: <input type="file" name="imagen" /> <br />
                    <input type="submit" value="Modificar Foto Evento" name="modificarFoto" />
                </form>
                <?php
            } else {
                echo "No tiene eventos creados, animate y crea el tuyo!";
            }

            mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta
            ?>
            <?php
        }
        ?>
    </body>
</html>
