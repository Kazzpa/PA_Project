<?php

require("../../conexion.php");

function parseToXML($htmlStr) {
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

// Select all the rows in the markers table
//si no nos dan ningun id de evento, seleccionamos todas las localizaciones y las mostramos
if (!isset($_GET['id'])) {
    $eventos = "SELECT `id`,`name`,`idLocation`,`date_celebration` FROM `events` WHERE `date_celebration`>CURRENT_TIMESTAMP";
} else {
    $idEvento = $_GET['id'];
//primero seleccionamos la localizacion del evento
    $queryEvento = "SELECT `idLocation` FROM `events` WHERE `id`='$idEvento'";
    $resultado_evento = mysqli_query($con, $queryEvento);
    $fila = mysqli_fetch_array($resultado_evento);
    $idLocation = $fila['idLocation'];

//recogemos los datos de la localizacion de ese evento
    $result_markers = "SELECT * FROM `locations` WHERE `id` = '$idLocation' ";
//buscamos cuantos eventos tienen ese idLocation
    $eventos = "SELECT `id`, `name`,`idLocation`,`date_celebration` FROM `events` WHERE `idLocation`='$idLocation'";
}
//guardamos los resultados de las consultas en un array auxiliar (el fech_assoc recorre y va perdiendo la info, por lo que al recorrer por segunda vez no encuentra nada)
$resultado_eventos = mysqli_query($con, $eventos);
while ($fila_eventos = mysqli_fetch_assoc($resultado_eventos)) {
    $arrayEventos[] = $fila_eventos;
}

if (!isset($_GET['id'])) {
    //nos quedamos solo con los id de los eventos
    foreach ($arrayEventos as $evento) {
        $idArrayEventos[] = $evento['idLocation'];
    }
    //eliminamos valores duplicados del array
    $idArrayEventos = array_unique($idArrayEventos);
    //preparamos el formato del IN del statement
    $in = '("' . implode('","', $idArrayEventos) . '")';
    $result_markers = "SELECT * FROM locations WHERE `id` IN " . $in;
}

$resultado_markers = mysqli_query($con, $result_markers) or die("Error en la consulta " . $result_markers);
while ($row_markers = mysqli_fetch_assoc($resultado_markers)) {
    $arrayLocalizacion[] = $row_markers;
}


//comienzo del archivo XML
header("Content-type: text/xml");

echo '<markers>';
// Iteramos por las filas, imprimiendo el XML para cada 
foreach ($arrayLocalizacion as $localizacion) {
    $i = 0;
    echo '<marker ';
    echo 'name="' . parseToXML($localizacion['name']) . '" ';
    echo 'address="' . parseToXML($localizacion['address']) . '" ';
    echo 'lat="' . $localizacion['lat'] . '" ';
    echo 'lng="' . $localizacion['lng'] . '" ';
    foreach ($arrayEventos as $evento) {
        if ($localizacion['id'] == $evento['idLocation']) {
            echo 'idEvent' . $i . '="' . $evento['id'] . '" ';
            echo 'nameEvent' . $i . '="' . $evento['name'] . '" ';
            echo 'date_celebration' . $i . '="' . $evento['date_celebration'] . '" ';
            $i++;
        }
    }
    echo 'numEvents="' . $i . '" ';
    echo '/>';
}

// Fin del fichero XML
echo '</markers>';
