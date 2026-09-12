/*
    script.js - js16 - Formulario de ABM

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

// Objetos del DOM
const objFormulario = document.getElementById("formABM");
const objApellido = document.getElementById("apellido");
const objNombres = document.getElementById("nombres");
const objSaldo = document.getElementById("saldo");

const objBtBlanquear = document.getElementById("btnBlanquear");
const objBtAlta = document.getElementById("btnAlta");
const objBtModi = document.getElementById("btnModi");
const objBtBaja = document.getElementById("btnBaja");

/* --------------------------------------------------------------------
   Carga inicial del documento: botones deshabilitados y foco en el
   primer input (pag. 14 y 15).
   -------------------------------------------------------------------- */
function cargaInicial() {
    objBtBlanquear.disabled = true;
    objBtAlta.disabled = true;
    objBtModi.disabled = true;
    objBtBaja.disabled = true;
    objApellido.select();
}

/* --------------------------------------------------------------------
   todoListo(): decide el estado de cada boton.
   - Blanquear: habilitado si hay algun dato cargado.
   - Alta, Modi y Baja: habilitados solo si el formulario completo
     valida con checkValidity() (pag. 13).
   -------------------------------------------------------------------- */
function todoListo() {
    if (objApellido.value != "" || objNombres.value != "" || objSaldo.value != "") {
        objBtBlanquear.disabled = false;
    }
    else {
        objBtBlanquear.disabled = true;
    }

    if (objFormulario.checkValidity()) {
        objBtAlta.disabled = false;
        objBtModi.disabled = false;
        objBtBaja.disabled = false;
    }
    else {
        objBtAlta.disabled = true;
        objBtModi.disabled = true;
        objBtBaja.disabled = true;
    }
}

/* --------------------------------------------------------------------
   Envia el formulario a la pagina de la operacion elegida, previa
   confirmacion del usuario (pag. 12). target "_blank" abre la
   respuesta en una pestana nueva.
   -------------------------------------------------------------------- */
function enviar(operacion) {
    var confirma = confirm("Esta seguro de enviar la " + operacion + "?");

    if (confirma) {
        objFormulario.method = "get";
        objFormulario.action = "./" + operacion + ".html";
        objFormulario.target = "_blank";
        objFormulario.submit();
    }
}

/* --------------------------------------------------------------------
   Listeners de eventos (pag. 15)
   -------------------------------------------------------------------- */
window.addEventListener("load", function () {
    cargaInicial();
});

// keyup y focus en cada input llaman a todoListo()
objApellido.addEventListener("keyup", function () {
    todoListo();
});
objApellido.addEventListener("focus", function () {
    todoListo();
});

objNombres.addEventListener("keyup", function () {
    todoListo();
});
objNombres.addEventListener("focus", function () {
    todoListo();
});

objSaldo.addEventListener("keyup", function () {
    todoListo();
});
objSaldo.addEventListener("focus", function () {
    todoListo();
});
// Las flechitas del input number cambian el valor sin teclear: no hay keyup
objSaldo.addEventListener("change", function () {
    todoListo();
});

objBtBlanquear.addEventListener("click", function () {
    objFormulario.reset();
    todoListo();
    objApellido.select();
});

objBtAlta.addEventListener("click", function () {
    enviar("alta");
});

objBtModi.addEventListener("click", function () {
    enviar("modi");
});

objBtBaja.addEventListener("click", function () {
    enviar("baja");
});
