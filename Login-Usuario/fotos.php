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

        <style type="text/css">
            .gallery img {
                width: 20%;
                height: auto;
                border-radius: 5px;
                cursor: pointer;
                transition: .3s;
            }
        </style>
    </head>
    <body>
        <?php include("header.php"); ?>
        <div class="container">
            <div class="gallery">                                                 
                <form action = "fotosIncluir.php" method = "post" enctype="multipart/form-data">          
                    <div class="form-group">
                        <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                        <input type = "text" name = "encabezado" class="form-control-file"/>
                    </div>
                    <div class="form-group">
                            <input type="submit"  value="Subir" name= "fotosIncluir" class="btnSubmit" />
                    </div>
                </form>  
                <?php 
                include 'functions.php';
                include('conexion.php');
            
                //Obtenemos el grupo seleccionado
                $idGrupo = 1;
               /* $bol = isset($_GET['grupo']) && $_GET['grupo'] != '';
                if ($bol) {
                    $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                        'grupo' => FILTER_SANITIZE_STRING);
                    $entradas = filter_input_array(INPUT_GET, $filtros);
                    $info = getGroup($entradas['grupo']);
                    $idGrupo = $info[0];
                    //Grupo valido pero no registrado
                    if(!$info){
                        $bol = false;
                    }
                }
                 */   
        
                //Obtenemos imagenes de la base de datos
                $query = $con->query("SELECT * FROM galery WHERE `grupo` = '$idGrupo'");

                if($query->num_rows > 0){
                    while($row = $query->fetch_assoc()){                      
                        $imageURL = $row["rutaImagen"];
                        ?>
                <table style="width:100%">
                    <tr>
                        <td>
                            <div>
                                <img src="<?php echo $imageURL; ?>">                                  
                                <p><?php echo $row["encabezado"]; 
                                    echo "<a href='fotosBorrado.php?id=". $row['id'] ."' title='Borrar Foto' data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a>"; ?></p>
                            </div>
                        </td>
                <?php }}  
                mysqli_close($con);
                ?>   
                </tr></table>                    
            </div>         
        </div>
    </body>
</html>