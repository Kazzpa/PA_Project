<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>home</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php include("stylesheets.php"); ?>
    </head>
    <body>
        <?php
        include("header.php");
        $evento_id = $_GET['id'];

        $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

        if (!$con) {
            die("Conexion fallida: " . mysqli_connect_error()); // Si la conexion ha fallado
        }

        $consulta = "SELECT * FROM `events` WHERE id = '$evento_id'"; //consulta SQL para obtener el usuario, luego comprobamos la password

        $resultado = mysqli_query($con, $consulta);

        mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

        if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
            $fila = mysqli_fetch_array($resultado);

            $nombreEvento = $fila['name'];
            $fechaCreacion = $fila['date_creation'];
            $fechaCelebracion = $fila['date_creation'];
            $creador = $fila['host'];
            $descripcion = $fila['description'];
            $evento_id = $fila['id'];
            $rutaimagen = $fila['rutaimagen'];

            echo "<h1>$nombreEvento</h1>";
            echo "<img src='$rutaimagen' alt='imagen del evento' style='width:30%;'><br />";
            echo "Creado el dia: $fechaCreacion<br />";
            echo "Su host sera: $creador y se celebrara el dia: $fechaCelebracion<br />";
            echo "Su host cree que necesitara saber lo siguiente: $descripcion";
        } else {
            echo "Evento inexistente";
        }
        ?>
    </body>
</html>