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
        <link rel="stylesheet" type="text/css" href="css/hojaestilo.css"/>                 
        <?php include("stylesheets.php"); ?>                 
    </head>
    <body>
        <?php include("header.php"); ?>
                                                
        <form action = "BackEnd/fotosIncluir.php" method = "post" enctype="multipart/form-data">          
                    <div class="form-group">                       
                        <b>Descripci&oacute;n de la imagen:</b>
                        <input type = "text" name = "encabezado" class="form-control-file" />
                        <input type="file" name="imagen" class="form-control-file"/> <!--Para el archivo se usa file control file-->
                    </div>
                    <p>
                        <input type="submit"  value="Subir" name= "fotosIncluir" class = "brn btn-primary" />
                    </p>
                  
                    
                </form> 
            
                <?php 
                include 'grupo_db.php';
                include('BackEnd/conexion.php');
            
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
                
                $query = $con->query("SELECT * FROM gallery WHERE `grupo` = '$idGrupo'");

                if($query->num_rows > 0){                                       
                    while($row = $query->fetch_assoc()){                      
                        $imageURL = $row["rutaImagen"];
                        ?>
                            
                        <div class="galeria">                                                                                
                            <a target="_blank" href="<?php echo $imageURL; ?>">
                                <img src="<?php echo $imageURL; ?>" alt="<?php echo $row['id']; ?>" width="600" height="400"> 
                            </a>
                            <div class="desc"><?php echo "<a href='fotosBorrado.php?id=". $row['id'] ."' title='Borrar Foto' data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a>";
                                                    echo $row["encabezado"];?>
                            </div>
                        </div> 
                <?php }}  
                mysqli_close($con);
                ?>                
                
    </body>
</html>
