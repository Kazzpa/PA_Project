function comprobarFormularioDatos() {
    var valor = document.getElementById("opcionModificacionCuenta").value;
    var zonaAdicion = document.getElementById("zonaModificacionDatos");

    if (valor == "email") {
        if (document.getElementById("datoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("datoACambiar"));
        }
        var dato = document.createElement("input");
        dato.id = "datoACambiar";
        dato.type = "email";
        dato.maxlength="255";
        dato.placeholder = "E-mail";
        dato.name = "campoTexto";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var boton = document.getElementById("botonModificacionDatos");
        boton.name = "modificarDato";
        boton.value = "Modificar Dato";
    } else if (valor == "password") {
        if (document.getElementById("datoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("datoACambiar"));
        }
        var dato = document.createElement("input");
        dato.id = "datoACambiar";
        dato.type = "password";
        dato.placeholder = "Password";
        dato.name = "campoTexto";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var boton = document.getElementById("botonModificacionDatos");
        boton.name = "modificarDato";
        boton.value = "Modificar Dato";
    } else if (valor == "foto") {
        if (document.getElementById("datoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("datoACambiar"));
        }
        var dato = document.createElement("input");
        dato.id = "datoACambiar";
        dato.type = "file";
        dato.name = "imagen";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var boton = document.getElementById("botonModificacionDatos");
        boton.name = "modificarFoto";
        boton.value = "Modificar Foto";
    }
}

function comprobarFormularioEventos() {
    var valor = document.getElementById("opcionModificacionEvento").value;
    var zonaAdicion = document.getElementById("zonaModificacionDatosEvento");

    if (valor == "name") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }
        //para hacer desaparecer el mapa
        if (document.getElementById("location").style.width == "62vw") {
            document.getElementById("location").style = "display:none;";
        }
        if (document.getElementById("mapsData").style.display == "") {
            document.getElementById("mapsData").style = "display:none;";
        }

        var dato = document.createElement("input");
        dato.id = "eventoACambiar";
        dato.type = "text";
        dato.maxlength="50";
        dato.minlength="3";
        dato.placeholder = "Nombre evento";
        dato.name = "campoTexto";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "../Evento/eventoModificar.php";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "botonEventoModificar";
        boton.value = "Modificar Evento";
    } else if (valor == "description") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }
        //para hacer desaparecer el mapa
        if (document.getElementById("location").style.width == "62vw") {
            document.getElementById("location").style = "display:none;";
        }
        if (document.getElementById("mapsData").style.display == "") {
            document.getElementById("mapsData").style = "display:none;";
        }
        var dato = document.createElement("textarea");
        dato.id = "eventoACambiar";
        dato.rows = "10";
        dato.cols = "60";
        dato.maxlength="500";
        dato.style = "resize: none;";
        dato.type = "password";
        dato.placeholder = "Introduzca la nueva descripccion";
        dato.name = "campoTexto";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "../Evento/eventoModificar.php";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "botonEventoModificar";
        boton.value = "Modificar Evento";
    } else if (valor == "imagen") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }
        //para hacer desaparecer el mapa
        if (document.getElementById("location").style.width == "62vw") {
            document.getElementById("location").style = "display:none;";
        }
        if (document.getElementById("mapsData").style.display == "") {
            document.getElementById("mapsData").style = "display:none;";
        }
        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "../Evento/eventoModificar.php";

        var dato = document.createElement("input");
        dato.id = "eventoACambiar";
        dato.type = "file";
        dato.name = "imagen";
        dato.required= "True";
        zonaAdicion.appendChild(dato);

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarFoto";
        boton.value = "Modificar Foto";
    } else if (valor == "eliminar") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }
        //para hacer desaparecer el mapa
        if (document.getElementById("location").style.width == "62vw") {
            document.getElementById("location").style = "display:none;";
        }
        if (document.getElementById("mapsData").style.display == "") {
            document.getElementById("mapsData").style = "display:none;";
        }

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarFoto";
        boton.value = "Eliminar evento";
        boton.onclick = function () {
            if (confirm("¿Seguro que quieres eliminar este evento?")) {
                var formulario = document.getElementById("formModificacionEvento");
                formulario.action = "../Evento/eventoEliminar.php";
            }
        };

    } else if (valor == "localizacion") {
        modificarLocalizacion();
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "../Localizacion/localizacionModificar.php";

        var mapa = document.getElementById("location");
        mapa.style = "width: 62vw; height:30vh";

        var mapsData = document.getElementById("mapsData");
        mapsData.style = "";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarLocalizacion";
        boton.value = "Modificar Localización";

    }
}

function avisarBorradoCuenta() {
    if (confirm("¿Seguro que quieres eliminar tu cuenta?")) {
        $.ajax({
            type: "POST",
            url: "cuentaEliminar.php",
            success: function (data) {
                alert(data);
                if (data == "Estamos muy tristes de que hayas decidido irte ¡Estaremos aqui esperándote!") {
                    window.location.href = "cuentaLogout.php";
                } else {
                    window.location.href = "../../index.php";
                }
            }
        });
    }
}
