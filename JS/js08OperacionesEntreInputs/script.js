/*
    script.js - js08 - Operaciones entre inputs

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const salida = document.getElementById("resultado");

/*
    Funcion con nombre, para no repetir en cada boton la lectura de los dos
    inputs y su conversion a numero. Devuelve el resultado ya escrito en el
    documento. Recibe el signo de la operacion y el valor calculado.
*/
function mostrar(a, signo, b, resultado) {
    salida.innerHTML = "<p>" + a + " " + signo + " " + b +
        " = <strong>" + resultado + "</strong></p>" +
        "<p>Tipo del resultado: " + typeof resultado + "</p>";
}

/*
    Otra funcion con nombre: valida que los dos campos tengan numeros.
    Devuelve true o false, asi cada manejador decide si sigue o avisa.
*/
function sonNumeros(a, b) {
    if (isNaN(a) || isNaN(b)) {     // el || es el operador logico "or" (pag. 9)
        salida.innerHTML = "<p>Completa los dos campos con numeros.</p>";
        return false;
    }
    return true;
}

/* --------------------------------------------------------------------
   Un manejador por cada boton. Todos hacen lo mismo: leer, convertir
   con parseInt, validar y mostrar. Solo cambia el operador.
   -------------------------------------------------------------------- */

document.getElementById("btnSuma").addEventListener("click", function () {
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (sonNumeros(a, b)) {
        mostrar(a, "+", b, a + b);
    }
});

document.getElementById("btnResta").addEventListener("click", function () {
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (sonNumeros(a, b)) {
        mostrar(a, "-", b, a - b);
    }
});

document.getElementById("btnMultiplicar").addEventListener("click", function () {
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (sonNumeros(a, b)) {
        mostrar(a, "*", b, a * b);
    }
});

document.getElementById("btnDividir").addEventListener("click", function () {
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (sonNumeros(a, b)) {
        // La division por cero en JavaScript no da error: devuelve Infinity.
        // Por eso la controlamos nosotros.
        if (b === 0) {
            salida.innerHTML = "<p>No se puede dividir por cero.</p>";
        }
        else {
            mostrar(a, "/", b, a / b);
        }
    }
});

document.getElementById("btnResto").addEventListener("click", function () {
    let a = parseInt(document.getElementById("a").value);
    let b = parseInt(document.getElementById("b").value);

    if (sonNumeros(a, b)) {
        mostrar(a, "%", b, a % b);
    }
});
