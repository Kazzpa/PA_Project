<?php

session_start();

$usuario = $_SESSION['username'];

$con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

if (!$con) {
    die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
}

$consulta = "DELETE FROM `users` WHERE username = '$usuario'"; //consulta SQL para obtener el usuario, luego comprobamos la password
$resultado = mysqli_query($con, $consulta);

mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

if ($resultado) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado   
    header('Refresh: 1; URL = cuentaLogout.php');
    echo "Estamos muy tristes de que haya decidido irse. Estaremos aqui esperandole!";
    exit();
} else {
    echo "Algo salio mal al intentar borrar la cuenta";
    header("Refresh: 5; URL = index.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
    exit();
}