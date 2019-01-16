$(document).ready(function () {
    $("#botonEventosPatrocinados").on("click", function () {
        $("#divEventosUsuarios")
                .fadeOut("slow", function () {
                    $("#divEventosPatrocinados").fadeIn("slow");
                });
    });
    $("#botonEventosUsuarios").on("click", function () {
        $("#divEventosPatrocinados")
                .fadeOut("slow", function () {
                    $("#divEventosUsuarios").fadeIn("slow");
                });
    });
});

