<?php

session_start();

/* HACE FALTA AÑADIR LAS VALIDACIONES */

$saneamiento = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
    'password' => FILTER_SANITIZE_STRING,
    'username' => FILTER_SANITIZE_STRING,
);

$saneado = filter_input_array(INPUT_POST, $saneamiento); /* entradas te devuelve un array asociativo clave valor con los campos del formulario */

$errores = array();
//A continuacion validamos
if (preg_match_all("/^[[:alnum:]]+$/", $saneado["password"]) == 0) {
    $errores[] = "Hay un error en la password";
}
if (preg_match_all("/^[[:alnum:]]+$/", $saneado["username"]) == 0) {
    $errores[] = "Hay un error en el usuario";
}

if (key_exists(0, $errores)) {  //Si hay algun error
    foreach ($errores as $clave => $valor) {
        echo "$valor <br/>";
    }
    echo "Le redireccionaremos al registro en 3 segundos";
} else {    //Si no hay errores seguimos procesando a la base de datos
    $usuario = $saneado['username']; //Rescatamos todas las variables del formulario y les hacemos un saneamiento
    $password = $saneado['password'];

    $con = mysqli_connect("localhost", "root", "", "infinity"); //La ventaja de poner aqui la base de datos que es opcional esque nos ahorramos una sentencia 

    if (!$con) {
        die("Conexion fallida: " . mysqli_connect_error()); /* Si la conexion ha fallado */
    }

    $consulta = "SELECT * FROM `users` WHERE username = '$usuario'"; //consulta SQL para obtener el usuario, luego comprobamos la password
    $resultado = mysqli_query($con, $consulta);
    $fila = mysqli_fetch_assoc($resultado);

    mysqli_close($con); //Cerramos la conexion a la base de datos ya que no nos hace falta

    if ($fila) {    //si la consulta ha tenido exito podemos guardar en SESSION la informacion como que existe y el usuario esta logeado
        if (password_verify($password, $fila['password'])) {    //si se verifica que son la misma password
            $_SESSION['login'] = "si";
            $_SESSION['username'] = $fila['username']; //Creamos la clave asociativa, asi ya sabemos que el usuario esta logueado
            $_SESSION['nombre'] = $fila['nombre'];
            $_SESSION['email'] = $fila['date_register'];
            $_SESSION['tipo'] = $fila['tipo'];

            if (isset($_SESSION["fallido"])) {  //Si el usuario habia fallado eliminamos la clave asociativa del fallo una vez se ha logueado correctamente
                unset($_SESSION["fallido"]);
            }
            if ($_SESSION['tipo'] == 0) {
                //$paginaWeb = $_SESSION['webRedirect']; SI HACE FALTA MIRAR LO DE LA REDIRECCION DESDE LA PAGINA DONDE ESTABAMOS
                header("Location: index.php", true, 301); // Redireccionamos al usuario a la pagina de login, debe ser usada antes que cualquier output 
                exit(); // Debemos terminar el script porque el script de la pagina no se sigue ejecutando tras usar header 
                //Devolvemos al usuario a la pagina en la que se encontraba previo al login
            } else if ($_SESSION['tipo'] == 0) {
                header("Location: paginaAdmin.php", true, 301); // Redireccionamos al administrador a la pagina de administracion 
                exit();
            }
        } else {    //esque hemos fallado la consulta de otra manera
            $_SESSION["fallido"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver 
            header("Location: cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
            exit();
        }
    } else {
        $_SESSION["fallido"] = TRUE; //Podriamos añadir un elemento para saber que la conexion ha fallado y devolver 
        header("Location: cuentaLogin.php"); //Como hemos fallado devolvemos al usuario a la pagina de login
        exit();
    }
}