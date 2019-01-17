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
        $limite = 5 * 1024 * 1024;

        function formCrearLogro() {
            echo '<form action="" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <b>Nombre logro: </b>
                <input type="text" class="form-control" name="logroname" placeholder="Nombre icono" required><br/>
            </div>
            <div class="form-group">
                <b>Descripcion del logro(ej: 100 miembros en el grupo):</b>
                <input type="text" class="form-control" name="logrodesc" placeholder="Descripcion" required><br/>
            </div>
            <div class="form-group">
                <b>Icono del logro: </b><br/>
                <input type="file" class="form-control custom-file-input" name="logroicon" accept="image/x-png,image/gif,image/jpeg" placeholder="ruta icono" required>
            </div>
            <div class="form-group">
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
            <div class="form-group">
                <b>Valor para conseguir el logro</b>
                <input type="number" class="form-control" name="logrovalor" min="1" max="" placeholder="valor" required><br/>
            </div>
            <div class="form-group">
                <b>Puntos del logro</b>
                <input type="number" class="form-control" name="logropuntos" placeholder="valor" required><br/>
            </div>
            <input type="submit" class="btn btn-primary" name="logrocrear" value="Crear">
            </form>
                ';
        }

        function checkEnviadoAdmin() {
            $bol = false;
            if (isset($_POST['logrocrear'])) {
                $bol = validarCrearLogro();
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

        function validarString($name, $size) {
            //regexp normal /^[0-9a-zñáéíóúü]+(.*|\s)*$/
            return preg_match("/^[[:alnum:]]+/", $name) && strlen($name) < $size && !empty(trim($name));
        }

        function validarImg($img) {
            //comprueba si no hubo un error en la subida
            if ($img["error"] == 0 && soloImg($img) && limiteTamanyo($img, $GLOBALS['limite'])) {
                return true;
            } else {
                return false;
            }
        }

        function soloImg($archivo) {
            $bool = False;
            if ($archivo["type"] == "image/png" || $archivo["type"] == "image/jpeg") {
                $bool = True;
            }

            return $bool;
        }

        function limiteTamanyo($archivo, $limite) {
            $bool = False;
            if (isset($archivo)) {
                if ($archivo["size"] <= $limite) {
                    $bool = True;
                }
            }
            return $bool;
        }

        //guarda en ficheros la foto
        function saveToDisk($archivo) {
            $bol = False;
            if (file_exists($archivo['tmp_name'])) {
                if (!file_exists($GLOBALS['rutaImg'])) {
                    mkdir($GLOBALS['rutaImg']);
                }
                if (move_uploaded_file($archivo['tmp_name'], $GLOBALS['rutaImg'] . $archivo['name'])) {
                    $bol = True;
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
                        formCrearLogro();
                    } else {
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

