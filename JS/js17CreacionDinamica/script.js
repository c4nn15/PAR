/*
    script.js - js17 - Creacion dinamica de objetos

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

// Objeto existente que contendra a los objetos creados
const objContenedor = document.getElementById("contenedor");

/* --------------------------------------------------------------------
   CREAR (pag. 17). Cada objeto nuevo se numera con la cantidad de
   hijos que ya tiene el contenedor + 1: el primero dice 1 aunque su
   indice en childNodes sea 0.
   -------------------------------------------------------------------- */
document.getElementById("btnCrear").addEventListener("click", function () {
    // Nuevo objeto del DOM: por ahora solo existe en memoria
    var objDiv = document.createElement("div");

    // Voy concatenando el contenido html en una variable de texto
    var textoHtml = "<h1>Elemento creado: ";
    textoHtml = textoHtml + (objContenedor.childNodes.length + 1);
    textoHtml = textoHtml + "</h1>";

    objDiv.innerHTML = textoHtml;

    // Clase tomada de la galeria de estilos (estilo.css)
    objDiv.className = "claseObjetoDinamico";

    // Recien aca se convierte en elemento HTML del documento
    objContenedor.appendChild(objDiv);

    // Escroleo el contenedor hasta abajo para ver el ultimo creado
    objContenedor.scrollTop = objContenedor.scrollHeight;
});

/* --------------------------------------------------------------------
   LIMPIAR (pag. 18). No hay un metodo clasico que borre todos los hijos
   de un saque: mientras queden nodos, borro siempre el primero.

   Alternativas (pag. 19):
       objContenedor.replaceChildren();
       objContenedor.innerHTML = "";   (menos eficiente: inicia el parser)
   -------------------------------------------------------------------- */
document.getElementById("btnLimpiar").addEventListener("click", function () {
    while (objContenedor.childNodes.length > 0) {
        objContenedor.removeChild(objContenedor.childNodes[0]);
    }
});

/* --------------------------------------------------------------------
   INFO: alertas con la longitud de childNodes y un barrido con forEach
   mostrando el indice y el texto de cada objeto.
   -------------------------------------------------------------------- */
document.getElementById("btnInfo").addEventListener("click", function () {
    alert("Longitud total (childNodes.length): " + objContenedor.childNodes.length);

    objContenedor.childNodes.forEach(function (item, indice) {
        alert("Objeto de indice " + indice + ": " + item.innerText);
    });
});
