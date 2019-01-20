<!-- Header que usamos a lo largo de la pagina para mostrar la navegacion-->
<div id="header">
    <header>
        <!-- Logo de la aplicacion-->
        <div id="logo">
            <a id="infinity-logo-header" href="index.php"><h1>Infinity</h1></a>
        </div>

        <!--Barra de navegacion donde se mostraran las distintas paginas-->
        <div id="header-nav">
            <nav>
                <a href="index.php" class="link"><i class="material-icons">home</i></a>
                <a href="eventoIndex.php" class="link"><i class="material-icons">event</i></a>
                <a href="Grupo.php" class="link"><i class="material-icons">group</i></a>
                <a href="cuentaLogin.php" class="link"><i class="material-icons">account_circle</i></a>
                <?php if (isset($_SESSION['login'])) echo "<a href='cuentaLogout.php' class='link'><i class='material-icons'>clear</i></a>"; ?>
            </nav>
        </div>
    </header>
</div>
