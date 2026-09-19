/*
    script.js - esp20 - Tabla + formulario en ventana modal

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    Las variables textoJSONClientes y textoJSONSucursales NO estan definidas
    aca: viven en ../clientes.js y ../sucursales.js, enlazados ANTES que este
    archivo (ver el final del html).

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const objTbDatos = document.getElementById("tbDatos");
const objSelSucursal = document.getElementById("selSucursal");
const objFormulario = document.getElementById("formCliente");

// Arreglo de objetos clientes: se llena en el ready() con JSON.parse()
var arrClientes = [];

/* --------------------------------------------------------------------
   TABLA (igual que esp10): recorre el arreglo con forEach() y arma una
   fila por cliente.
   -------------------------------------------------------------------- */
function cargarDatos() {
    // Saco la fila de estado vacio antes de agregar las filas reales
    $("#filaVacia").remove();

    arrClientes.forEach(function (argValor) {
        agregarFila(argValor);
    });
}

/* --------------------------------------------------------------------
   VACIAR DATOS: igual que en esp10, empty() vacia el tbody y despues se
   vuelve a crear la fila de estado vacio.
   -------------------------------------------------------------------- */
function vaciarTabla() {
    $("#tbDatos").empty();

    var objTrVacia = document.createElement("tr");
    objTrVacia.id = "filaVacia";
    objTrVacia.innerHTML = '<td colspan="7">Todavía no se cargaron datos. Apretá "Cargar datos" o "Cargar Form".</td>';
    objTbDatos.appendChild(objTrVacia);
}

function agregarFila(argCliente) {
    // Por si se envia el formulario sin haber apretado antes "Cargar datos"
    $("#filaVacia").remove();

    var objTr = document.createElement("tr");

    agregarCelda(objTr, argCliente.codCliente);
    agregarCelda(objTr, argCliente.codSucursal);
    agregarCelda(objTr, argCliente.direccionEntrega);
    agregarCelda(objTr, argCliente.diaSemanalEntrega);
    agregarCelda(objTr, argCliente.costoPromedioTransporte);
    agregarCelda(objTr, argCliente.fechaUltimaEntrega);
    agregarCelda(objTr, argCliente.fotoPuntoEntrega);

    objTbDatos.appendChild(objTr);
}

function agregarCelda(argFila, argValor) {
    var objTd = document.createElement("td");
    objTd.innerHTML = argValor;
    argFila.appendChild(objTd);
}

/* --------------------------------------------------------------------
   SELECT DE SUCURSAL (igual que esp05): poblado dinamicamente desde la
   tabla auxiliar.
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
   VENTANA MODAL (igual que esp15), aplicada al div#contenedor que ahora
   envuelve tambien a la tabla.
   -------------------------------------------------------------------- */
function abrirModal() {
    document.getElementById('contenedor').className = "contenedorPasivo";
    document.getElementById('ventanaModal').className = "ventanaModalPrendido";
}

function cerrarModal() {
    document.getElementById('contenedor').className = "contenedorActivo";
    document.getElementById('ventanaModal').className = "ventanaModalApagado";
}

$(document).ready(function () {
    // Paso 1: parsear el JSON y quedarme con el arreglo de clientes
    var objJsonClientes = JSON.parse(textoJSONClientes);
    arrClientes = objJsonClientes.clientes;

    poblarSelectSucursales();

    $("#btCargar").click(function () {
        cargarDatos();
    });

    $("#btVaciar").click(function () {
        vaciarTabla();
    });

    $("#btAbrirForm").click(function () {
        abrirModal();
    });

    $("#btCerrar").click(function () {
        cerrarModal();
    });

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

        // Se agrega al arreglo en memoria Y a la tabla que ya esta en pantalla
        arrClientes.push(objNuevoCliente);
        agregarFila(objNuevoCliente);

        objFormulario.reset();
        cerrarModal();
    });
});
