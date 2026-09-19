/*
    script.js - esp15 - Ventana modal

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    La variable textoJSONSucursales NO esta definida aca: vive en
    ../sucursales.js, que se enlaza ANTES que este archivo (ver el final del
    html).

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const objSelSucursal = document.getElementById("selSucursal");
const objFormulario = document.getElementById("formCliente");

/* --------------------------------------------------------------------
   Poblar el select de sucursal (igual que en esp05), recorriendo la tabla
   auxiliar con forEach() (pag. 5 y 6 del apunte de json).
   -------------------------------------------------------------------- */
function poblarSelectSucursales() {
    var objJsonSucursales = JSON.parse(textoJSONSucursales);

    objJsonSucursales.sucursales.forEach(function (argValor) {
        var objOpcion = document.createElement("option");
        objOpcion.setAttribute("value", argValor.codSucursal);
        objOpcion.innerHTML = argValor.nombreSucursal + " (" + argValor.codSucursal + ")";
        objSelSucursal.appendChild(objOpcion);
    });
}

/* --------------------------------------------------------------------
   Abre el modal (pag. 8 del apunte de especiales):
   - el contenedor de fondo pasa a la clase "pasivo" (transparente y sin
     click).
   - el modal pasa a la clase "prendido" (visible).
   -------------------------------------------------------------------- */
function abrirModal() {
    document.getElementById('contenedor').className = "contenedorPasivo";
    document.getElementById('ventanaModal').className = "ventanaModalPrendido";
}

/* --------------------------------------------------------------------
   Cierra el modal: vuelve todo al estado inicial.
   -------------------------------------------------------------------- */
function cerrarModal() {
    document.getElementById('contenedor').className = "contenedorActivo";
    document.getElementById('ventanaModal').className = "ventanaModalApagado";
}

$(document).ready(function () {
    poblarSelectSucursales();

    $("#btAbrir").click(function () {
        abrirModal();

        // $(window).width(): objeto del BOM, version jQuery
        alert("Ancho de ventana: " + $(window).width());
    });

    $("#btCerrar").click(function () {
        cerrarModal();
    });

    /* --------------------------------------------------------------------
       ENVIAR: este ejercicio no tiene tabla ni arreglo de clientes en
       memoria (eso lo hace esp20). Aca alcanza con armar el objeto y
       mostrarlo con un alert(), para practicar el formulario dentro del
       modal.
       -------------------------------------------------------------------- */
    $("#btEnviar").click(function () {
        var objNuevoCliente = {
            codCliente: $("#codCliente").val(),
            codSucursal: objSelSucursal.value,
            direccionEntrega: $("#direccionEntrega").val(),
            diaSemanalEntrega: $("#selDia").val(),
            costoPromedioTransporte: Number($("#costoPromedioTransporte").val()),
            fechaUltimaEntrega: $("#fechaUltimaEntrega").val(),
            fotoPuntoEntrega: $("#fotoPuntoEntrega").val()
        };

        if (!objFormulario.checkValidity()) {
            objFormulario.reportValidity();
            return;
        }

        alert("Cliente cargado en el formulario:\n" + JSON.stringify(objNuevoCliente, null, 2));

        objFormulario.reset();
        cerrarModal();
    });
});
