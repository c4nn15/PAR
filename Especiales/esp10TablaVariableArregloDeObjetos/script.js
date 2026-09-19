/*
    script.js - esp10 - Tabla + variable JSON + arreglo de objetos

    Funciones y manejadores de evento de este documento.
    Se enlaza desde el html con la etiqueta:
        <script src="./script.js"></script>

    La variable textoJSONClientes NO esta definida aca: vive en ../clientes.js,
    que se enlaza ANTES que este archivo (ver el final del html).

    OJO: dentro de un archivo .js NO se escribe la etiqueta <script>,
    el archivo entero ya es codigo JavaScript. Los comentarios son
    de dos tipos: // de una linea, o barra-asterisco como este.
*/

const objTbDatos = document.getElementById("tbDatos");

/* --------------------------------------------------------------------
   CARGAR DATOS (pag. 7 del apunte de json).

   Primero: parsear el texto JSON para obtener el arreglo de clientes.
   Segundo: barrer ese arreglo con forEach().
   Tercero: por cada cliente, crear en memoria una fila y sus celdas, y
   agregar la fila terminada al tbody.
   -------------------------------------------------------------------- */
function cargarDatos() {
    // Saco la fila de estado vacio antes de agregar las filas reales
    $("#filaVacia").remove();

    var objJsonClientes = JSON.parse(textoJSONClientes);

    objJsonClientes.clientes.forEach(function (argValor) {
        var objTr = document.createElement("tr");

        agregarCelda(objTr, argValor.codCliente);
        agregarCelda(objTr, argValor.codSucursal);
        agregarCelda(objTr, argValor.direccionEntrega);
        agregarCelda(objTr, argValor.diaSemanalEntrega);
        agregarCelda(objTr, argValor.costoPromedioTransporte);
        agregarCelda(objTr, argValor.fechaUltimaEntrega);
        agregarCelda(objTr, argValor.fotoPuntoEntrega);

        objTbDatos.appendChild(objTr);
    });
}

/* --------------------------------------------------------------------
   Crea una celda <td>, le pone el nodo de texto que llega como argumento
   y la agrega a la fila. Se llama una vez por cada atributo del cliente.
   -------------------------------------------------------------------- */
function agregarCelda(argFila, argValor) {
    var objTd = document.createElement("td");
    objTd.innerHTML = argValor;
    argFila.appendChild(objTd);
}

/* --------------------------------------------------------------------
   VACIAR DATOS: empty() saca TODAS las filas (incluida la de estado vacio,
   si por algun motivo seguia ahi), y despues se vuelve a crear esa fila
   para que la tabla nunca quede realmente en blanco.
   -------------------------------------------------------------------- */
function vaciarTabla() {
    // empty() es un metodo exclusivo de jQuery: vacia TODO el contenido
    // del contenedor de un saque (pag. 4 del apunte de especiales)
    $("#tbDatos").empty();

    var objTr = document.createElement("tr");
    objTr.id = "filaVacia";
    objTr.innerHTML = '<td colspan="7">Todavía no se cargaron datos. Apretá "Cargar datos".</td>';
    objTbDatos.appendChild(objTr);
}

/* --------------------------------------------------------------------
   $(document).ready() + listeners con jQuery (pag. 3 del apunte de
   especiales).
   -------------------------------------------------------------------- */
$(document).ready(function () {
    $("#btCargar").click(function () {
        cargarDatos();
    });

    $("#btVaciar").click(function () {
        vaciarTabla();
    });
});
