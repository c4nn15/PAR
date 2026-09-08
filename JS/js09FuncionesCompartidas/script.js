/*
    script.js - js09 - Funciones compartidas

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const salida = document.getElementById("resultado");

/*
    LA FUNCION COMPARTIDA (pag. 19 del apunte).

    Nombre: mayor. Devuelve el mayor de 2 numeros.
    Recibe dos argumentos con los cuales operara.

    Los convertimos adentro con parseInt para que la comparacion sea
    numerica: si compararamos los strings "10" y "9", el navegador los
    compararia como texto y "9" resultaria mayor que "10".
*/
function mayor(arg1, arg2) {

    // let: alcance de bloque, viven solo mientras dura la funcion
    let var1 = parseInt(arg1);
    let var2 = parseInt(arg2);

    if (var1 >= var2) {
        return var1;        // valor retornado
    }
    else {
        return var2;
    }
}

/*
    Funcion auxiliar para leer un input por su id. Tambien esta compartida
    por los dos manejadores de evento.
*/
function leer(id) {
    return document.getElementById(id).value;
}

/* --------------------------------------------------------------------
   Procedimiento de evento 1: invoca a mayor() una sola vez.
   -------------------------------------------------------------------- */
document.getElementById("btnDos").addEventListener("click", function () {

    let a = leer("n1");
    let b = leer("n2");

    if (isNaN(parseInt(a)) || isNaN(parseInt(b))) {
        salida.innerHTML = "<p>Completa los dos primeros campos con numeros.</p>";
    }
    else {
        salida.innerHTML = "<p>Entre " + a + " y " + b +
            " el mayor es: <strong>" + mayor(a, b) + "</strong></p>";
    }

});

/* --------------------------------------------------------------------
   Procedimiento de evento 2: invoca a LA MISMA funcion, anidada, para
   resolver el caso de tres numeros. Esto es reutilizar codigo.
   -------------------------------------------------------------------- */
document.getElementById("btnTres").addEventListener("click", function () {

    let a = leer("n1");
    let b = leer("n2");
    let c = leer("n3");

    if (isNaN(parseInt(a)) || isNaN(parseInt(b)) || isNaN(parseInt(c))) {
        salida.innerHTML = "<p>Completa los tres campos con numeros.</p>";
    }
    else {
        // El resultado de la primera invocacion es el argumento de la segunda
        let elMayor = mayor(mayor(a, b), c);

        salida.innerHTML = "<p>Entre " + a + ", " + b + " y " + c +
            " el mayor es: <strong>" + elMayor + "</strong></p>";
    }

});
