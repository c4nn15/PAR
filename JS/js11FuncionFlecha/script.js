/*
    script.js - js11 - Funcion flecha

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const salida = document.getElementById("resultado");

/* 1) Declaracion tradicional: la palabra clave function y el nombre. */
function sumaTradicional(a, b) {
    return a + b;
}

/* 2) Funcion anonima guardada en una constante.
      const no se puede ni redeclarar ni reasignar, asi que nadie puede
      pisar la funcion mas adelante: por eso es ideal para declararlas. */
const sumaAnonima = function (a, b) {
    return a + b;
};

/* 3) Funcion flecha (arrow function), a partir de ES6.
      Es la misma declaracion que la anterior pero sin la palabra function
      y con la flecha => despues de los parametros. */
const sumaFlecha = (a, b) => {
    return a + b;
};

/* --------------------------------------------------------------------
   Manejador del boton, escrito tambien con una funcion flecha.
   Invoca a las tres funciones: se llaman todas exactamente igual.
   -------------------------------------------------------------------- */
document.getElementById("btnSumar").addEventListener("click", () => {

    // parseInt, porque el value de un input siempre es string
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (isNaN(a) || isNaN(b)) {
        salida.innerHTML = "<p>Completa los dos campos con numeros.</p>";
    }
    else {
        salida.innerHTML =
            "<p>sumaTradicional(" + a + ", " + b + ") = <strong>" + sumaTradicional(a, b) + "</strong></p>" +
            "<p>sumaAnonima(" + a + ", " + b + ") = <strong>" + sumaAnonima(a, b) + "</strong></p>" +
            "<p>sumaFlecha(" + a + ", " + b + ") = <strong>" + sumaFlecha(a, b) + "</strong></p>" +
            "<p>Las tres devuelven lo mismo: cambia como se declaran, no como se invocan.</p>";
    }

});
