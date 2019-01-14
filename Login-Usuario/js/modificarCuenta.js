function comprobarFormularioDatos() {
    var valor = document.getElementById("opcionModificacionCuenta").value;
    var zonaAdicion = document.getElementById("zonaModificacionDatos");

    if (valor == "email") {
        if (document.getElementById("datoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("datoACambiar"));
        }
        var dato = document.createElement("input");
        dato.id = "datoACambiar";
        dato.type = "text";
        dato.placeholder = "E-mail";
        dato.name = "campoTexto";
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
        var dato = document.createElement("input");
        dato.id = "eventoACambiar";
        dato.type = "text";
        dato.placeholder = "Nombre evento";
        dato.name = "campoTexto";
        zonaAdicion.appendChild(dato);

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "eventoModificar.php";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "botonEventoModificar";
        boton.value = "Modificar Evento";
    } else if (valor == "description") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }
        var dato = document.createElement("textarea");
        dato.id = "eventoACambiar";
        dato.rows = "10";
        dato.cols = "60";
        dato.style = "resize: none;";
        dato.type = "password";
        dato.placeholder = "Introduzca la nueva descripccion";
        dato.name = "campoTexto";
        zonaAdicion.appendChild(dato);

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "eventoModificar.php";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "botonEventoModificar";
        boton.value = "Modificar Evento";
    } else if (valor == "imagen") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "eventoModificar.php";

        var dato = document.createElement("input");
        dato.id = "eventoACambiar";
        dato.type = "file";
        dato.name = "imagen";
        zonaAdicion.appendChild(dato);

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarFoto";
        boton.value = "Modificar Foto";
    } else if (valor == "eliminar") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "eventoEliminar.php";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarFoto";
        boton.value = "Eliminar evento";
        
    } else if (valor == "localizacion") {
        if (document.getElementById("eventoACambiar")) {
            zonaAdicion.removeChild(document.getElementById("eventoACambiar"));
        }

        var formulario = document.getElementById("formModificacionEvento");
        formulario.action = "localizacionModificar.php";
        
        var mapa = document.getElementById("location");
        mapa.style="";

        var mapsData = document.getElementById("mapsData");
        mapsData.style="";

        var boton = document.getElementById("botonEventoModificar");
        boton.name = "modificarLocalizacion";
        boton.value = "Modificar Localización";
        
        
    }
}


