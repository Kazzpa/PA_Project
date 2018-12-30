<?php

require("conexion.php");

function parseToXML($htmlStr) {
    $xmlStr = str_replace('<', '&lt;', $htmlStr);
    $xmlStr = str_replace('>', '&gt;', $xmlStr);
    $xmlStr = str_replace('"', '&quot;', $xmlStr);
    $xmlStr = str_replace("'", '&#39;', $xmlStr);
    $xmlStr = str_replace("&", '&amp;', $xmlStr);
    return $xmlStr;
}

// Select all the rows in the markers table
if (!isset($_GET['id'])) {
    $result_markers = "SELECT * FROM locations";
} else {
    $idEvento = $_GET['id'];
    $queryEvento = "SELECT `idLocation` FROM `events` WHERE `id`='$idEvento'";
    $resultado_evento = mysqli_query($con, $queryEvento);
    $fila = mysqli_fetch_array($resultado_evento);
    $idLocation = $fila['idLocation'];
    
    $result_markers = "SELECT * FROM `locations` WHERE `id` = '$idLocation' ";
    //$result_markers = "SELECT `locations`.`name`,`locations`.`address`,`locations`.`lat`,`locations`.`lng` FROM `locations`,`events` WHERE `events`.`idLocation`=`locations`.`id`";
}
$resultado_markers = mysqli_query($con, $result_markers);

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row_markers = mysqli_fetch_assoc($resultado_markers)) {
    // Add to XML document node
    echo '<marker ';
    echo 'name="' . parseToXML($row_markers['name']) . '" ';
    echo 'address="' . parseToXML($row_markers['address']) . '" ';
    echo 'lat="' . $row_markers['lat'] . '" ';
    echo 'lng="' . $row_markers['lng'] . '" ';
    //echo 'type="' . $row_markers['type'] . '" ';
    echo '/>';
}

// End XML file
echo '</markers>';



