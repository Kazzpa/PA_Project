<!-- Header que usamos a lo largo de la pagina para mostrar la navegacion-->
<div id="header-top">
    <div id="header-fixed" class="sticky">
        <header id="header"> 
            <!-- Logo de la aplicacion-->
            <div id="logo">
                <a id="infinity-logo-header" href="../../index.php"><h1 id="head-logo">Infinity</h1></a>
            </div>

            <!--Barra de navegacion donde se mostraran las distintas paginas-->
            <div id="header-nav">
                <nav>
                    <a href="../../index.php" class="link"><i class="material-icons">home</i></a>
                    <a href="../Evento/eventoIndex.php" class="link"><i class="material-icons">event</i></a>
                    <a href="../Grupo/grupo_mostrar.php" class="link"><i class="material-icons">group</i></a>
                    <a href="../Usuario/cuentaLogin.php" class="link"><i class="material-icons">account_circle</i></a>
                    <?php
                    if (isset($_SESSION['login']) && $_SESSION['tipo'] == 1) {
                        echo "<a href='../../paginaAdmin.php' class='link'><i class='material-icons'>build</i></a>";
                    }
                    if (isset($_SESSION['login'])) {
                        echo "<a href='../Usuario/cuentaLogout.php' class='link'><i class='material-icons'>clear</i></a>";
                    }
                    ?>
                </nav>
            </div>
        </header>
    </div>
</div>

<!--<script type="text/javascript">
    // When the user scrolls the page, execute myFunction 
    window.onscroll = function () {
        myFunction()
    };

// Get the header
    var header = document.getElementById("header-fixed");
    var logo = document.getElementById("head-logo");
    var link = document.getElementsByClassName("material-icons");

// Get the offset position of the navbar
    var sticky = document.getElementById("header-top").offsetTop;

// Add the sticky class to the header when you reach its scroll position. Remove "sticky" when you leave the scroll position
    function myFunction() {
        if (window.pageYOffset > sticky) {
            header.classList.add("sticky");
            logo.classList.add("sticky-elements-header");
            for(var i=0;i<link.length;i++){
                link[i].id = "sticky-elements";
            }
        } else {
            header.classList.remove("sticky");
            logo.classList.remove("sticky-elements-header");
            for(var i=0;i<link.length;i++){
                link[i].removeAttribute("id");
            }
        }
    }
</script>-->
