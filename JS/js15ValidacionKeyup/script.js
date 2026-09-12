/*
    script.js - js15 - Validacion en el evento keyup

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const objFormulario = document.getElementById("miform");
const objDia = document.getElementById("dia");
const objMes = document.getElementById("mes");

/* --------------------------------------------------------------------
   VALIDACION EN KEYUP (pag. 13). Al soltar cada tecla se chequea la
   validacion HTML5 del input. Si no valida, alerta y blanqueo.

   Se ignora el input vacio: si no, borrar con la tecla de retroceso,
   llegar con Tab o cerrar la alerta con Enter tambien dispararian la
   alerta (vacio no cumple con required).
   -------------------------------------------------------------------- */
objDia.addEventListener("keyup", function () {
    if (objDia.value != "" && !objDia.checkValidity()) {
        alert("El valor debe estar entre 1 y 31");
        objDia.value = "";
        objDia.select();
    }
});

objMes.addEventListener("keyup", function () {
    if (objMes.value != "" && !objMes.checkValidity()) {
        alert("El valor debe estar entre 1 y 12");
        objMes.value = "";
        objMes.select();
    }
});

/* --------------------------------------------------------------------
   ENVIO Y RESET DESDE JAVASCRIPT (pag. 12).
   Antes de enviar se chequea la validacion del formulario completo.
   -------------------------------------------------------------------- */
document.getElementById("btnEnviar").addEventListener("click", function () {
    if (objFormulario.checkValidity()) {
        objFormulario.method = "get";
        objFormulario.action = "./respuestaFormulario.html";
        objFormulario.submit();
    }
    else {
        alert("Valor ingresado no valido!! Completar dia y mes.");
        objDia.select();
    }
});

document.getElementById("btnReset").addEventListener("click", function () {
    objFormulario.reset();
    objDia.select();
});
