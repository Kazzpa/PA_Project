<?php

session_start();
include_once("conexion.php");

//Recibimos los datos del formulario
$datos = filter_input_array(INPUT_POST, FILTER_DEFAULT);
if ($datos['name'] == "" || $datos['address'] == "" || $datos['city'] == "" || $datos['lat'] == "" || $datos['lng'] == "") {
    $_SESSION['msg'] = "<span style='color: red';>No puede haber ningun campo vacio</span>";
    header("Location: index.php");
} else {

//Guardamos en la BD
    $result_markers = "INSERT INTO locations(name, address, city, lat, lng) 
				VALUES 
				('" . $datos['name'] . "', '" . $datos['address'] . "', '" . $datos['city'] . "', '" . $datos['lat'] . "', '" . $datos['lng'] . "')";

    $resultado_markers = mysqli_query($con, $result_markers);

    
    //obtenemos la id de la localizacion creada
    $idLocalizacion = $con->insert_id;
}
?>