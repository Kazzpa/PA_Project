<?php
include('conexion.php');

if ($bol) {
    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
        'grupo' => FILTER_SANITIZE_STRING);
    $entradas = filter_input_array(INPUT_GET, $filtros);
    $info = getGroup($entradas['grupo']);
    $idGrupo = $info[0];
    //Grupo valido pero no registrado
    if (!$info) {
        $bol = false;
    }

//Obtenemos imagenes de la base de datos
    $query = $con->query("SELECT * FROM gallery WHERE `grupo` = '$idGrupo'");
    mysqli_close($con);
    $image['URL'] = Array();
    $image['ID'] = Array();
    $image['encabezado'] = Array();
    if ($query->num_rows > 0) {
        echo "<h2 class='align-center'>Galería de fotos</h2><div class='demo-gallery'><ul id='lightgallery' class='list-unstyled row'>";
        while ($row = $query->fetch_assoc()) {
            array_push($image['URL'], $row["rutaImagen"]);
            array_push($image['ID'], $row["id"]);
            array_push($image['encabezado'], $row["encabezado"]);
        }
        $totURL = implode(",", $image['URL']);
        for ($i = 0; $i < sizeof($image['URL']); $i++) {
            if (isset($_SESSION['username']) && isset($_GET['grupo'])) {
                include('grupoIsAdmin.php');
                if ($admin) {
                    ?>
                    <li class="gallery" data-src="<?php echo $image['URL'][$i]; ?>" data-responsive="<?php echo $image['URL'][$i]; ?>" 
                        data-sub-html="<p id='img<?php echo $image['ID'][$i]; ?>'><?php echo $image["encabezado"][$i]; ?></p><div class='edit' id='<?php echo $image['ID'][$i]; ?>'>Editar encabezado</div><div class='delete' id='<?php echo $image['ID'][$i]; ?>'>Eliminar foto</div>">
                    <?php }
                } else {
                    ?>
                <li class="gallery" data-src="<?php echo $image['URL'][$i]; ?>" data-responsive="<?php echo $image['URL'][$i]; ?>" 
                    data-sub-html="<p id='img<?php echo $image['ID'][$i]; ?>'><?php echo $image["encabezado"][$i]; ?></p>">
            <?php } ?>
                <a href="<?php echo $image['URL'][$i]; ?>">
                    <img src="<?php echo $image['URL'][$i]; ?>" alt="" title="<?php echo $image["encabezado"][$i]; ?>"  class ="img-responsive"/>
                </a>
            </li>

            <?php
        }
        echo "</ul></div>";
    }
}
        