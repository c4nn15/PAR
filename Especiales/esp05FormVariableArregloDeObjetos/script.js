/*
    script.js - esp05 - Formulario + variable JSON + arreglo de objetos

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    Las variables textoJSONClientes y textoJSONSucursales NO estan definidas
    aca: viven en ../clientes.js y ../sucursales.js, y llegan a este documento
    porque esos dos archivos se enlazan ANTES que este (ver el final del html).

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

// Objetos del DOM que se usan mas de una vez
const objSelSucursal = document.getElementById("selSucursal");
const objFormulario = document.getElementById("formCliente");
const objContador = document.getElementById("pContador");

// Arreglo de objetos clientes: se llena en el ready() de mas abajo, parseando
// la variable de texto JSON declarada en ../clientes.js
var arrClientes = [];

/* --------------------------------------------------------------------
   Recorre el arreglo de sucursales (la tabla AUXILIAR) y crea en memoria
   una <option> por cada una, con document.createElement() (pag. 5 y 6 del
   apunte de json).
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
   Muestra cuantos objetos tiene el arreglo de clientes en este momento.
   -------------------------------------------------------------------- */
function actualizarContador() {
    objContador.innerHTML = "Clientes cargados en el arreglo: <strong>" + arrClientes.length + "</strong>";
}

/* --------------------------------------------------------------------
   $(document).ready() es el equivalente en jQuery de esperar a que el
   documento termine de cargar (pag. 3 del apunte de especiales).
   -------------------------------------------------------------------- */
$(document).ready(function () {
    // Paso 1: el texto JSON se convierte en un objeto real de Java script
    var objJsonClientes = JSON.parse(textoJSONClientes);

    // Paso 2: el atributo "clientes" de ese objeto es el arreglo que nos interesa
    arrClientes = objJsonClientes.clientes;

    poblarSelectSucursales();
    actualizarContador();

    // click() es el metodo de jQuery para el listener del evento click
    $("#btAgregar").click(function () {
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

        // El objeto nuevo se agrega al FINAL del arreglo, en memoria
        arrClientes.push(objNuevoCliente);
        actualizarContador();

        // JSON.stringify hace el camino inverso a JSON.parse: de objeto a texto
        alert("Cliente agregado al arreglo:\n" + JSON.stringify(objNuevoCliente, null, 2));

        objFormulario.reset();
        $("#codCliente").trigger("focus");
    });
});
