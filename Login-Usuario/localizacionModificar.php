<?php

session_start();
include_once("conexion.php");

//Recibimos los datos del formulario
$datos = filter_input_array(INPUT_POST, FILTER_DEFAULT);

if ($datos['name'] == "" || $datos['address'] == "" || $datos['city'] == "" || $datos['lat'] == "" || $datos['lng'] == "") {
    $_SESSION['msg'] = "<span style='color: red';>No puede haber ningun campo vacio</span>";
    header("Location: index.php");
} else {
    //Comprobamos si esa localizacion tiene mas de un evento asociado
    // Para ello primero obtenemos la id de la localizacion del evento que se quiere modificar
    $idEvento = $_POST["selectEvento"];
    $query = "SELECT `idLocation` FROM `events` WHERE `id` =" . $idEvento;
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $idLocalizacion = $row['idLocation'];

    //Comprobamos si existe mas de un evento con esa idLocation en eventos
    $consulta = "SELECT `id` FROM `events` WHERE `idLocation`='$idLocalizacion'";
    $resultado = mysqli_query($con, $consulta);
    if (mysqli_num_rows($resultado) < 2) { //si la consulta devuelve menos de 2 valores es porque solo está registrado 1 vez
        //En cuyo caso no se insertaría la localizacion otra vez en la bd sino que se modifica esa localizacion con los nuevos datos
        $modificacion = "UPDATE `locations` SET `name` = '" . $datos['name'] . "',`address` = '" . $datos['address'] . "',`city` = '" . $datos['city'] . "',`lat` = '" . $datos['lat'] . "',`lng` = '" . $datos['lng'] . "'  WHERE `locations`.`id` =" . $idLocalizacion;
        $resultado_modificacion = mysqli_query($con, $modificacion);
    } else {
        //si la consulta devuelve 2 valores o mas es porque hay mas eventos con esa localizacion asociada, en cuyo caso se crea una localizacion nueva
        $result_markers = "INSERT INTO locations(name, address, city, lat, lng) 
				VALUES 
				('" . $datos['name'] . "', '" . $datos['address'] . "', '" . $datos['city'] . "', '" . $datos['lat'] . "', '" . $datos['lng'] . "')";

        $resultado_markers = mysqli_query($con, $result_markers);

        //obtenemos la id de la localizacion creada
        $idLocalizacion = $con->insert_id;

        //y se la ponemos al evento
        $update = "UPDATE `events` SET `idLocation` = '$idLocalizacion' WHERE `events`.`id` = '$idEvento'";
        $resultado = mysqli_query($con, $consulta);
    }
    mysqli_close($con);
    header("Location: cuentaLogin.php");
}
?>