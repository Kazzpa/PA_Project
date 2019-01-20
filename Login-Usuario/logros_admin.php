<html>
    <head>
        <title>Admin-Logros</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <?php include 'stylesheets.php'; ?>
    </head>
    <body>
        <?php
        include 'header.php';
        include 'logros_db.php';
        include 'validation.php';
        $limite = 5 * 1024 * 1024;

        function formCrearLogro() {
            return '</form>
                <form action="" method="POST" enctype="multipart/form-data" >
            
            <div class="form-group col-md-4">
                <b>Nombre logro: </b>
                <input type="text" class="form-control" name="logroname" placeholder="Nombre icono" required><br/>
            </div>
            <div class="form-group col-md-4 custom-file">
                <b>Icono del logro: </b><br/>
                <input type="file" class="custom-file-input" id="customFile" name="logroicon" accept="image/x-png,image/gif,image/jpeg"required>
            </div>
            <div class="form-group col-md-4">
                <b>Descripcion del logro</b>(ej: 100 miembros en el grupo):
                <input type="text" class="form-control" name="logrodesc" placeholder="Descripcion" required><br/>
            </div>
            <div class="form-group col-md-4">
                <b>Tipo de logro</b>
                <select class="custom-select" name="logrotipo" required>
                <option value="0" selected>N&uacute;mero de miembros</option>
                <option value="1">N&uacute;mero de comentarios</option>
                <option value="2">N&uacute;mero de fotos</option>
                <option value="3">N&uacute;mero de eventos</option>
                <option value="4">N&uacute;mero de puntos</option>
                <option value="5">Rey de la web o especial</option>
              </select>
            </div>
            <div class="form-group col-md-4">
                <b>Valor necesario para conseguirlo</b>
                <input type="number" class="form-control" name="logrovalor" min="1" placeholder="valor" required><br/>
            </div>
            <div class="form-group col-md-4">
                <b>Puntos a obtener</b>
                <input type="number" class="form-control" name="logropuntos" placeholder="puntos" required><br/>
            </div>
            <input type="submit" class="btn btn-primary" name="logrocrear" value="Crear">
            </form>
                ';
        }

        //Comprueba si existe el logro especificado
        //logro session:
        //0:id 1:name 2:icon_path 3:descripcion 4:tipo 5:valor 6:puntos
        function modGrupo() {
            $str = '<h4> Panel Modificar logro </h4>
                <form action="" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <b>Modificar Nombre: </b><i>"' . utf8_decode($_SESSION['logro'][1]) . '"</i><br/>
                    <input type="text" class="form-control" name="logroName" placeholder="Nombre"><br/>
                    </div>';
            $str .= '<div class="form-group">
                    <b>Modificar Imagen: </b><br/>';
            if (file_exists($_SESSION['logro'][2])) {
                $str .= '<img src="' . $_SESSION['logro'][2] . '" alt="imagen de logro:' . $_SESSION['logro'][1] . '></img><br/>';
            }
            $str .= '<input type="file" class="form-control" name="logroImg" placeholder="ruta imagen"><br/>
                    </div><div class="form-group">
                        <b>Modificar descripcion: </b>
                        <br/><i>"' . $_SESSION['logro'][3] . '" </i><br/>
                        <input type="text" class="form-control" name="logroDesc" placeholder="Descripcion"><br/>
                    </div>
                    <div class="form-group">
                        <b>Modificar tipo: </b>
                        <div class="form-group col-md-4">
                        <b>Tipo de logro</b>
                        <select class="custom-select" name="logrotipo">
                        <option value="0"';
            if ($_SESSION['logro'][4] == 0) {
                $str .= 'selected';
            }
            $str .= '>N&uacute;mero de miembros</option>
                        <option value="1"';
            if ($_SESSION['logro'][4] == 1) {
                $str .= 'selected';
            }
            $str .= '>N&uacute;mero de comentarios</option>
                        <option value="2"';
            if ($_SESSION['logro'][4] == 2) {
                $str .= 'selected';
            }
            $str .= '>N&uacute;mero de fotos</option>
                        <option value="3"';
            if ($_SESSION['logro'][4] == 3) {
                $str .= 'selected';
            }
            $str .= '>N&uacute;mero de eventos</option>
                        <option value="4"';
            if ($_SESSION['logro'][4] == 4) {
                $str .= 'selected';
            }
            $str .= '>N&uacute;mero de puntos</option>
                        <option value="5"';
            if ($_SESSION['logro'][4] == 5) {
                $str .= 'selected';
            }
            $str .= '>Rey de la web o especial</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <i>' . $_SESSION['logro'][5] . ' </i>
                        <b>Valor necesario para conseguirlo</b>
                        <input type="number" class="form-control" name="logrovalor" min="1" placeholder="valor"><br/>
                    </div>
                    <div class="form-group col-md-4">
                        <b>Puntos a obtener</b>
                        <i>' . $_SESSION['logro'][6] . ' </i>
                        <input type="number" class="form-control" name="logropuntos" placeholder="puntos"><br/>
                    </div>
                    <input type="submit" class="btn btn-primary" name="modLogro" value="Modificar">
                    <input type="submit" class="btn btn-danger" name="EliminarLogro" value="Eliminar">
            </form>';
            return $str;
        }

        function checkEnviadoAdmin() {
            $bol = false;
            if (isset($_POST['logrocrear'])) {
                $bol = validarCrearLogro();
            }else if(isset($_SESSION['logro']) && isset($_POST['modLogro'])){
                
            }else if(iiset($_SESSION['logro']) && isset($_POST['ELiminarLogro'])){
                
            }
            return $bol;
        }

        // comprobamos : logroname  logrodesc logroicon logrotipo logrovalor logropuntos
        //Devolvemos true si son validos, falso si no
        function validarCrearLogro() {
            $bol = false;
            if (isset($_POST['logroname']) && isset($_POST['logrodesc']) && isset($_FILES['logroicon']) && isset($_POST['logrotipo']) && isset($_POST['logrovalor']) && isset($_POST['logropuntos'])) {
                $filtros = Array(//Evitamos la inyeccion sql haciendo un saneamiento de los datos que nos llegan
                    'logroname' => FILTER_SANITIZE_STRING,
                    'logrodesc' => FILTER_SANITIZE_STRING,
                    'logrotipo' => FILTER_SANITIZE_NUMBER_INT,
                    'logrovalor' => FILTER_SANITIZE_NUMBER_INT,
                    'logropuntos' => FILTER_SANITIZE_NUMBER_INT,
                );
                $entradas = filter_input_array(INPUT_POST, $filtros);
                //no valido a fondo tipo,valor y puntos WIP
                if (validarString($entradas['logroname'], 50) && validarString($entradas['logrodesc'], 200) && validarImg($_FILES['logroicon'])) {
                    $name = $entradas['logroname'];
                    $desc = $entradas['logrodesc'];
                    $img = $_FILES['logroicon'];
                    $tipo = $entradas['logrotipo'];
                    $valor = $entradas['logrovalor'];
                    $puntos = $entradas['logropuntos'];
                    $guardadoDB = crearLogro($name, $img, $desc, $tipo, $valor, $puntos);
                    if ($guardadoDB) {
                        saveToDisk($img);
                        $bol = true;
                    }
                }
            }
            return $bol;
        }

        //Comprobaciones usuario sea admin si no redirigir a home
        // WIP

        $bol = checkEnviadoAdmin();
        ?>
        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-sm-2 sidenav">
                </div>
                <div class="col-sm-8 text-center well" >
                    <?php
                    if (!$bol) {
                        echo (formCrearLogro());
                    } else {
                        //si el logro se creo con exito
                        echo '<h3 class="alert alert-success" role="alert">
                            Logro creado con exito!
                          </h3>';
                    }
                    ?>
                </div>
                <div class="col-sm-2 sidenav">
                </div>                 
            </div>
        </div>

        <footer class="container-fluid text-center">
            <div>Icons made by <a href="https://www.freepik.com/" title="Freepik">Freepik</a> from <a href="https://www.flaticon.com/" 			    title="Flaticon">www.flaticon.com</a> is licensed by <a href="http://creativecommons.org/licenses/by/3.0/" 			    title="Creative Commons BY 3.0" target="_blank">CC 3.0 BY</a></div>
        </footer>
    </body>
</html>

