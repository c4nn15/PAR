/*
    script.js - js12 - Objeto location del BOM

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const salida = document.getElementById("resultado");

/* --------------------------------------------------------------------
   LECTURA del BOM. Estas propiedades no son del documento sino del
   navegador: location es la URL y navigator la configuracion (pag. 1 y 2).
   -------------------------------------------------------------------- */
salida.innerHTML =
    "<p><strong>location.href:</strong> " + location.href + "</p>" +
    "<p><strong>location.protocol:</strong> " + location.protocol +
    " (si abriste el archivo con doble clic dice file:)</p>" +
    "<p><strong>location.pathname:</strong> " + location.pathname + "</p>" +
    "<p><strong>window.navigator.userAgent:</strong> " + window.navigator.userAgent + "</p>" +
    "<p><strong>window.navigator.language:</strong> " + window.navigator.language + "</p>";

// Lo mismo, mandado a la consola de depuracion
console.log("URL actual: " + location.href);

/* --------------------------------------------------------------------
   ESCRITURA sobre el BOM: asignarle un valor a location.href provoca
   una redireccion a otro host/dominio por JavaScript (pag. 21).
   -------------------------------------------------------------------- */
document.getElementById("btnYoutube").addEventListener("click", function () {
    location.href = "https://www.youtube.com";
});

/* La redireccion tambien sirve para navegar dentro del propio sitio.
   El ../../ sube dos carpetas: de js12Location a JS, y de JS a la raiz. */
document.getElementById("btnPortada").addEventListener("click", function () {
    location.href = "../../index.html";
});

/* reload() es un metodo del objeto location: vuelve a cargar el documento */
document.getElementById("btnRecargar").addEventListener("click", function () {
    location.reload();
});
