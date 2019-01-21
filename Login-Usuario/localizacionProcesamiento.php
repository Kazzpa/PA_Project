<?php

include_once("conexion.php");

//Recibimos los datos del formulario
$datos = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($datos['name'] == "" || $datos['address'] == "" || $datos['city'] == "" || $datos['lat'] == "" || $datos['lng'] == "") {
    $_SESSION['msg'] = "<span style='color: red';>No puede haber ningun campo vacio</span>";
    header("Location: index.php");
} else {
    //Comprobamos si el usuario introducido ya existe, pues este va a hacer de pk en nuestra base de datos
    $name = $datos['name'];
    $consulta = "SELECT `id` FROM `locations` WHERE `name`='$name'";
    $resultado = mysqli_query($con, $consulta);

    if (!(mysqli_num_rows($resultado) > 0)) { //si la consulta no devuelve ningun valor es porque esa localizacion no esta insertada
        //Guardamos en la BD
        $result_markers = "INSERT INTO locations(name, address, city, lat, lng) 
				VALUES 
				('" . $datos['name'] . "', '" . $datos['address'] . "', '" . $datos['city'] . "', '" . $datos['lat'] . "', '" . $datos['lng'] . "')";

        $resultado_markers = mysqli_query($con, $result_markers);

        //obtenemos la id de la localizacion creada
        $idLocalizacion = $con->insert_id;
        
    } else { //Si la consulta devuelve alguna fila es porque encontro alguna coincidencia, en cuyo caso no se insertaría la localizacion otra vez en la bd
        $fila = mysqli_fetch_assoc($resultado);
        $idLocalizacion = $fila['id'];
    }
     mysqli_close($con);
}