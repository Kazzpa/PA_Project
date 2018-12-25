<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login with Bootstrap</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            body{
                font-family: 'Raleway', sans-serif;
                text-align:center;
            }
            /* Remove the navbar's default margin-bottom and rounded borders */ 
            .navbar {
                margin-bottom: 0;
                border-radius: 0;
            }
            /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
            .row.content {height: 450px}
            /* Set gray background color and 100% height */
            .sidenav {
                padding-top: 20px;
                background-color: #f1f1f1;
                height: 100%;
            }
            /* Set black background color, white text and some padding */
            footer {
                background-color: #555;
                color: white;
                padding: 15px;
            }
            /* On small screens, set height to 'auto' for sidenav and grid */
            @media screen and (max-width: 767px) {
                .sidenav {
                    height: auto;
                    padding: 15px;
                }
                .row.content {height:auto;} 
            </style>
            <link rel="icon" href="icons/coding.svg">
            <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
            <!-- Libreria de bootstrap -->
            <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"  crossorigin="anonymous">
            <link rel="stylesheet" href="css/hojaestilo.css"  crossorigin="anonymous">
        </head>
        <body class="text-center">
            <div id="header">
                <header>
                    <div id="logo">
                        <h1>Infinity</h1>
                    </div>
                </header>
                <div id="header-nav">
                    <a href="index.html" class="link"><i class="material-icons">home</i></a>
                    <a href="form.html" class="link"><i class="material-icons">event</i></a>
                    <a href="login.php" class="link"><i class="material-icons">account_circle</i></a>
                </div>
            </div>
            <div class="container-fluid text-center">    
                <div class="row content">
                    <div class="col-sm-3 sidenav">
                    </div>
                    <div class="col-sm-6 text-center"> 
                        <form class="form-signin" action="" method="POST">
                            <img class="mb-4" src="icons/user.svg" alt="" width="100" >
                            <h1 class="h3 mb-3 font-weight-normal"> Login</h1>    
                            <input type="text" class="form-control" placeholder="Usuario">
                            <input type="password"  class="form-control" placeholder="Contraseña">
                            <div class="checkbox mb-3">
                                <label>
                                    <input type="checkbox" value="remember-me"> Recuerdame
                                </label>
                            </div>
                            <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
                        </form>
                    </div>
                    <div class="col-sm-3 sidenav">
                    </div>
                </div>
            </div>
            <!-- Libreria de bootstrap -->
            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" crossorigin="anonymous"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" crossorigin="anonymous"></script>
            <!--Poner al fallar el login 
                 <div class="alert alert-danger">
                                <strong>Error!</strong> Datos incorrectos, vuelva a introducirlos.
                            </div>
            -->
        </body>
    </html>
