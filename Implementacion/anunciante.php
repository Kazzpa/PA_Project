<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
    <?php include("stylesheets.php"); ?>
    <link rel="stylesheet" type="text/css" href="CSS/hojaestilo.css"/>
    <!--Activar etiquetas de elementos a visualizar con el cursor-->
    <script type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();   
        });
    </script>
</head>
<body>
    <div class="envoltura">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="page-header clearfix">
                        <h2 class="pull-left">Lista de Anunciantes</h2>                      
                    </div>
                    <?php                  
                    require_once "conexion.php";                   
                
                    $sql = "SELECT * FROM advertisers";
                    
                    if($resultado = mysqli_query($con, $sql)){
                        if(!(mysqli_num_rows($resultado)) == 0){
                            echo "<table class='table table-bordered table-striped'>";
                                echo "<thead>";                       
                                    echo "<tr><th>ID</th><th>Nombre</th><th>Organizacion</th><th>Alias</th><th>Acción</th></tr>";                                                                   
                                echo "</thead>";
                                echo "<tbody>";
                                while($fila = mysqli_fetch_array($resultado)){
                                    echo "<tr>";
                                        echo "<td>" . $fila['id'] . "</td>" . "<td>" . $fila['name'] . "</td>" . "<td>" . $fila['organization'] . "</td>" . "<td>" . $fila['alias'] . "</td>";                                   
                                        echo "<td>";
                                            echo "<a href='anuncianteLectura.php?id=". $fila['id'] ."' title='Vista de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-info-sign'></span></a>";
                                            echo "<a href='anuncianteModificar.php?id=". $fila['id'] ."' title='Actualizacion de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-pencil'></span></a>";
                                            echo "<a href='anuncianteBorrar.php?id=". $fila['id'] ."' title='Borrado de registro' data-toggle='tooltip'><span class='glyphicon glyphicon-remove'></span></a>";
                                        echo "</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";                            
                            echo "</table>";
                            echo "<a href='anuncianteCrear.php' class='btn btn-primary pull-right'>Añadir Anunciante</a>";
                            mysqli_free_result($resultado);
                        } else{
                            echo "<p class='lead'><em>Registros no encontrados.</em></p>";
                        }
                    } else{
                        echo "ERROR:No se pudo ejecutar $sql. " . mysqli_error($con);
                    }
                    // Cerrar conexion
                    mysqli_close($con);
                    ?>
                </div>
            </div>        
        </div>
    </div>
</body>
</html>