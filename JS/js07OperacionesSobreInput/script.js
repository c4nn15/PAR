/*
    script.js - js07 - Operaciones sobre un input

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

/* Guardamos en constantes los objetos del DOM con los que vamos a trabajar.
   Usamos const porque son objetos que no vamos a reasignar en todo el script. */
const entradaX = document.getElementById("x");
const salida = document.getElementById("resultado");

/* --------------------------------------------------------------------
   Boton 1: la forma correcta. parseInt convierte el string del input
   en un number, y recien ahi el + suma de verdad (pag. 18 del apunte).
   -------------------------------------------------------------------- */
document.getElementById("btnSumar").addEventListener("click", function () {

    // let: alcance de bloque, vive solo mientras dura este manejador
    let numero = parseInt(entradaX.value);

    // Si el usuario no escribio un numero, parseInt devuelve NaN (Not a Number)
    if (isNaN(numero)) {
        salida.innerHTML = "<p>Escribi un numero en el campo de arriba.</p>";
    }
    else {
        let resultado = numero + 10;
        salida.innerHTML = "<p>" + numero + " + 10 = <strong>" + resultado + "</strong></p>" +
            "<p>Tipo del resultado: " + typeof resultado + "</p>";
    }

});

/* --------------------------------------------------------------------
   Boton 2: el error clasico. Sin parseInt, el value es string y el
   operador + concatena en vez de sumar (coercion de tipos, pag. 2).
   -------------------------------------------------------------------- */
document.getElementById("btnConcatenar").addEventListener("click", function () {

    let resultado = entradaX.value + 10;

    salida.innerHTML = "<p>\"" + entradaX.value + "\" + 10 = <strong>" + resultado + "</strong></p>" +
        "<p>Tipo del resultado: " + typeof resultado + " &mdash; se concateno, no se sumo.</p>";

});

/* --------------------------------------------------------------------
   Boton 3: muestra que el value de cualquier input del DOM es string.
   -------------------------------------------------------------------- */
document.getElementById("btnTipo").addEventListener("click", function () {

    salida.innerHTML = "<p>El value del input es: \"" + entradaX.value + "\"</p>" +
        "<p>Su tipo es: <strong>" + typeof entradaX.value + "</strong></p>" +
        "<p>Convertido con parseInt() pasa a ser: <strong>" +
        typeof parseInt(entradaX.value) + "</strong></p>";

});
