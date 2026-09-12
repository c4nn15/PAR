/*
    script.js - js13 - Traduccion segun el idioma del navegador

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

/* --------------------------------------------------------------------
   Los dos mensajes, uno por idioma.
   -------------------------------------------------------------------- */
const mensajeCastellano = "Aprender a estudiar en serio";
const mensajeIngles = "Learn to study seriously";

/* --------------------------------------------------------------------
   Idioma default del navegador: primer elemento del array languages
   (pag. 1). Es un string del tipo "es-AR" o "en-US", asi que con
   substr(0, 2) nos quedamos solo con el codigo de idioma (pag. 3).
   -------------------------------------------------------------------- */
const idiomaCompleto = window.navigator.languages[0];
const idioma = idiomaCompleto.substr(0, 2);

// Condicional que conmuta el mensaje segun el idioma
if (idioma == "en") {
    document.getElementById("titulo").innerHTML = mensajeIngles;
}
else {
    document.getElementById("titulo").innerHTML = mensajeCastellano;
}

/* --------------------------------------------------------------------
   Informacion extra para ver que devuelve el BOM. La propiedad
   .constructor.name devuelve el prototipo del objeto, o el tipo si
   se trata de un dato simple (pag. 2).
   -------------------------------------------------------------------- */
document.getElementById("resultado").innerHTML =
    "<p><strong>window.navigator.languages:</strong> " + window.navigator.languages +
    " (prototipo: " + window.navigator.languages.constructor.name + ")</p>" +
    "<p><strong>window.navigator.languages[0]:</strong> " + idiomaCompleto +
    " (tipo: " + idiomaCompleto.constructor.name + ")</p>" +
    "<p><strong>window.navigator.language:</strong> " + window.navigator.language + "</p>" +
    "<p><strong>substr(0, 2):</strong> " + idioma + "</p>" +
    "<p><strong>window.navigator.constructor.name:</strong> " + window.navigator.constructor.name + "</p>" +
    "<p><strong>window.constructor.name:</strong> " + window.constructor.name + "</p>";
