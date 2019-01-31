<?php session_start(); ?>
<!--
======================================================================
 PANEL DE CONTROL DEL ADMINISTRADOR
======================================================================
-->

<!-- Comprobacion de que el usuario que esta accediendo es administrador-->
<?php
//Importaciones tanto de la hoja de estilos como de la cabecera
include("stylesheets.php");
include("header.php");

if (isset($_SESSION['username']) && isset($_SESSION['tipo'])) {
    if ($_SESSION['tipo'] == 1) {   //Si el usuario que accede tiene permisos, le mostramos el panel de usuario
        ?>
        <!--
        -----------------------------------------------------
        Muestra por pantalla de las opciones de administrador
        -----------------------------------------------------
        -->
        <div class="col-sm-2 sidenav">
        </div>
        <div class="col-sm-8 text-center well">
            <a href='Entidades/Anunciante/anunciante.php'>Administrar anunciantes</a><br />
            <a href='Entidades/Evento/eventoAnuncianteCreacion.php'>Dar alta evento anunciantes</a><br/>
            <!-- Habria que cambiar esto debido a que ahora estos php solo tienen funciones.-->
        </div>
        <div class="col-sm-2 sidenav">
        </div>
        <?php
    } else {
        echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
    }
} else {
    echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
}
?>
