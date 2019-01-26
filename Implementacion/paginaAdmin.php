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
        <a href='anunciante.php'>Administrar anunciantes</a><br />
        <a href='eventoAnuncianteCreacion.php'>Dar alta evento anunciantes</a><br/>
        <a href='logros_admin.php'>Administrar logros </a><br/>
        <a href='adminGrupo.php'>Administrar grupos </a><br/>

        <?php
    } else {
        echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
    }
} else {
    echo "<p>Lo sentimos no tiene permisos para acceder a esta pagina</p>";
}
?>
