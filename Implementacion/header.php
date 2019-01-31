<!--
======================================================================
HEADER
======================================================================
-->
<div id="header-top">
    <div id="header-fixed" class="sticky">
        <header id="header"> 
            <!-- Logo de la aplicacion-->
            <div id="logo">
                <a id="infinity-logo-header" href="index.php"><h1 id="head-logo">Infinity</h1></a>
            </div>

            <!--Barra de navegacion donde se mostraran las distintas paginas-->
            <div id="header-nav">
                <nav>
                    <a href="index.php" class="link"><i class="material-icons">home</i></a>
                    <a href="Entidades/Evento/eventoIndex.php" class="link"><i class="material-icons">event</i></a>
                    <a href="Entidades/Grupo/grupo_mostrar.php" class="link"><i class="material-icons">group</i></a>
                    <a href="Entidades/Usuario/cuentaLogin.php" class="link"><i class="material-icons">account_circle</i></a>
                    <?php
                    if (isset($_SESSION['login']) && $_SESSION['tipo'] == 1) {
                        echo "<a href='paginaAdmin.php' class='link'><i class='material-icons'>build</i></a>";
                    }
                    if (isset($_SESSION['login'])) {
                        echo "<a href='Entidades/Usuario/cuentaLogout.php' class='link'><i class='material-icons'>clear</i></a>";
                    }
                    ?>
                </nav>
            </div>
        </header>
    </div>
</div>
