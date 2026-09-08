/*
    script.js - js10 - Convertir a mayusculas

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const salida = document.getElementById("resultado");

/* --------------------------------------------------------------------
   Funcion anonima para definir un procedimiento de evento para el
   cambio de foco de un input (pag. 18 del apunte).

   El evento focusout se dispara cuando el campo pierde el foco.
   Adentro usamos this porque el mismo objeto sensible al evento es el
   que cambia su propiedad value.
   -------------------------------------------------------------------- */
document.getElementById("nombre").addEventListener("focusout", function () {

    this.value = this.value.toUpperCase();   // metodo de transformacion a mayusculas

    salida.innerHTML = "<p>El campo Nombre quedo asi: <strong>" + this.value + "</strong></p>";

});

/* Exactamente el mismo codigo sirve para otro campo, sin tocar una letra:
   eso es lo que se gana usando this en lugar del id. */
document.getElementById("apellido").addEventListener("focusout", function () {

    this.value = this.value.toUpperCase();

    salida.innerHTML = "<p>El campo Apellido quedo asi: <strong>" + this.value + "</strong></p>";

});

/* El metodo inverso: toLowerCase() pasa todo el contenido a minusculas. */
document.getElementById("mail").addEventListener("focusout", function () {

    this.value = this.value.toLowerCase();

    salida.innerHTML = "<p>El campo Correo quedo asi: <strong>" + this.value + "</strong></p>";

});
