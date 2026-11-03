<?php include "../manejoSesion.inc"; ?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <title>php10 - ABM</title>

    <meta name="addsearch-category" content="PHP, MySQL, PDO, fetch, ABM, CRUD, binarios" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>PHP, sesión: ABM de clientes</h1>
        <p class="alumno">Alumno: Santiago Cannistra</p>
    </header>

    <hr />

    <main id="contenedorTablaClientes" class="contenedorActivo">

        <div class="botonera">
            <button type="button" id="btCargar" title="Trae los registros del servidor aplicando el orden y los filtros actuales">Carga de datos</button>
            <button type="button" id="btVaciar" title="Vacía la tabla sin consultar al servidor">Vaciar datos</button>
            <button type="button" id="btLimpiar" title="Borra el contenido de todos los filtros">Limpiar filtros</button>
            <button type="button" id="btAlta" title="Abre el formulario para dar de alta un nuevo cliente">Alta registro</button>
            <button type="button" id="btCierraSesion" title="Cierra la sesión y vuelve al login">Cerrar sesión</button>
            <label for="orden">Orden:</label>
            <input type="text" id="orden" value="codCliente" title="Campo por el que está ordenada la tabla (se cambia haciendo click en un título de columna)" readonly />
        </div>

        <div class="tablaScroll">
            <table>
                <thead>
                    <tr class="titulos">
                        <th id="th_clientes_codCliente">Cod. cliente</th>
                        <th id="th_clientes_codSucursal">Sucursal</th>
                        <th id="th_clientes_direccionEntrega">Direccion de entrega</th>
                        <th id="th_clientes_diaSemanalEntrega">Dia de entrega</th>
                        <th id="th_clientes_costoPromedioTransporte">Costo transporte</th>
                        <th id="th_clientes_fechaUltimaEntrega">Ultima entrega</th>
                        <th>Foto</th>
                        <th>Modis</th>
                        <th>Bajas</th>
                    </tr>
                    <tr class="filtros">
                        <th><input type="text" id="f_clientes_codCliente" title="Filtrar por código de cliente (contiene el texto)" /></th>
                        <th>
                            <!-- Desplegable poblado con el JSON de salidaJsonSucursales.php -->
                            <select id="f_clientes_codSucursal" title="Filtrar por sucursal">
                                <option value=""></option>
                            </select>
                        </th>
                        <th><input type="text" id="f_clientes_direccionEntrega" title="Filtrar por dirección de entrega (contiene el texto)" /></th>
                        <th><input type="text" id="f_clientes_diaSemanalEntrega" title="Filtrar por día de entrega (por ej. Lunes)" /></th>
                        <th><input type="text" id="f_clientes_costoPromedioTransporte" title="Filtrar por costo promedio de transporte" /></th>
                        <th><input type="text" id="f_clientes_fechaUltimaEntrega" placeholder="aaaa-mm-dd" title="Filtrar por fecha de última entrega, formato aaaa-mm-dd" /></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbDatos">
                    <tr id="filaVacia">
                        <td colspan="9">Todavía no se cargaron datos. Apretá "Carga de datos".</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="9">
                            Tabla: Agrupacion de datos logisticos clientes - Santiago Cannistra -
                            Registros: <input type="text" id="cuenta" value="0" size="4" title="Cantidad de registros recibidos" readonly />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </main>

    <!-- Ventana modal del formulario (sirve para alta y para modi) -->
    <div id="ventanaModalFormulario" class="ventanaModal">
        <div class="modalCaja">
            <div class="modalEncabezado">
                <span id="tituloFormulario">Formulario</span>
                <button type="button" id="btCerrarFormulario" class="btCelda" title="Cierra el formulario sin enviar">Cerrar</button>
            </div>

            <form id="formClientes" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="formCodCliente">Cod. cliente:</label>
                        <input type="text" id="formCodCliente" name="codCliente" maxlength="10" title="Código único del cliente, hasta 10 caracteres (no se puede cambiar en una modificación)" required />
                    </li>
                    <li>
                        <label for="formCodSucursal">Sucursal:</label>
                        <select id="formCodSucursal" name="codSucursal" title="Sucursal que atiende al cliente" required></select>
                    </li>
                    <li>
                        <label for="formDireccionEntrega">Direccion de entrega:</label>
                        <input type="text" id="formDireccionEntrega" name="direccionEntrega" maxlength="100" title="Dirección donde se entrega la mercadería, hasta 100 caracteres" required />
                    </li>
                    <li>
                        <label for="formDiaSemanalEntrega">Dia de entrega:</label>
                        <select id="formDiaSemanalEntrega" name="diaSemanalEntrega" title="Día de la semana en que se entrega (de lunes a sábado)" required>
                            <option value=""></option>
                            <option>Lunes</option>
                            <option>Martes</option>
                            <option>Miercoles</option>
                            <option>Jueves</option>
                            <option>Viernes</option>
                            <option>Sabado</option>
                        </select>
                    </li>
                    <li>
                        <label for="formCostoPromedioTransporte">Costo transporte:</label>
                        <input type="number" id="formCostoPromedioTransporte" name="costoPromedioTransporte" min="0" step="any" title="Costo promedio de transporte, número mayor o igual a 0" required />
                    </li>
                    <li>
                        <label for="formFechaUltimaEntrega">Ultima entrega:</label>
                        <input type="date" id="formFechaUltimaEntrega" name="fechaUltimaEntrega" title="Fecha de la última entrega realizada" required />
                    </li>
                    <li>
                        <label for="formFotoPuntoEntrega">Foto / documento:</label>
                        <input type="file" id="formFotoPuntoEntrega" name="fotoPuntoEntrega" title="Foto o documento del punto de entrega (opcional)" />
                    </li>
                </ul>
            </form>

            <div class="modalPie">
                <button type="button" id="btEnvioForm" title="Envía el formulario al servidor; se habilita cuando los datos son válidos" disabled>Enviar</button>
            </div>
        </div>
    </div>

    <!-- Ventana modal de respuestas del servidor (PDF/foto, resultado de alta, modi y baja) -->
    <div id="ventanaModalRespuesta" class="ventanaModal">
        <div class="modalCaja">
            <div class="modalEncabezado">
                <span id="encabezadoModalRespuesta">Respuesta del servidor</span>
                <button type="button" id="btCerrarRespuesta" class="btCelda" title="Cierra la ventana de respuesta">Cerrar</button>
            </div>
            <div id="contenidoModalRespuesta"></div>
        </div>
    </div>

    <hr />

    <footer>
        <p><a href="../index.html">Volver al indice de PHP</a></p>

        Santiago Cannistra
        <address>
            Programación en Ambiente de Redes
        </address>
    </footer>

    <script>
        const objTbDatos = document.getElementById("tbDatos");
        const objTablero = document.getElementById("contenedorTablaClientes");
        const objFormulario = document.getElementById("formClientes");
        const objBtEnvio = document.getElementById("btEnvioForm");

        // Campos de la tabla: cada uno tiene un titulo clickeable (orden) y un filtro
        const campos = ["codCliente", "codSucursal", "direccionEntrega", "diaSemanalEntrega", "costoPromedioTransporte", "fechaUltimaEntrega"];

        // Campo del formulario (id) de cada campo de la tabla
        const idForm = {
            codCliente: "formCodCliente",
            codSucursal: "formCodSucursal",
            direccionEntrega: "formDireccionEntrega",
            diaSemanalEntrega: "formDiaSemanalEntrega",
            costoPromedioTransporte: "formCostoPromedioTransporte",
            fechaUltimaEntrega: "formFechaUltimaEntrega",
        };

        // Titulo de cada campo (etiqueta de las celdas en pantallas chicas)
        const etiquetas = {
            codCliente: "Cod. cliente",
            codSucursal: "Sucursal",
            direccionEntrega: "Direccion de entrega",
            diaSemanalEntrega: "Dia de entrega",
            costoPromedioTransporte: "Costo transporte",
            fechaUltimaEntrega: "Ultima entrega",
        };

        // Lista de sucursales: la usan el filtro y el formulario
        let objGlobalSucursales = { sucursales: [] };

        // "alta" o "modi": define a que script se envia el formulario
        let modoFormulario = "alta";

        // Valores del registro al abrir la modi, para detectar si cambio algo
        let valoresOriginales = {};

        function mensajeTbody(argTexto) {
            objTbDatos.innerHTML = "";
            const objTr = document.createElement("tr");
            objTr.id = "filaVacia";
            objTr.innerHTML = '<td colspan="9">' + argTexto + '</td>';
            objTbDatos.appendChild(objTr);
        }

        function vaciarTabla() {
            mensajeTbody('Todavía no se cargaron datos. Apretá "Carga de datos".');
            document.getElementById("cuenta").value = 0;
        }

        function agregarCelda(argFila, argValor, argEtiqueta) {
            const objTd = document.createElement("td");
            objTd.dataset.label = argEtiqueta;
            objTd.textContent = argValor;
            argFila.appendChild(objTd);
        }

        // Crea una celda con un boton y le asigna el manejador de click
        function agregarCeldaBoton(argFila, argTexto, argClase, argManejador, argDeshabilitado, argEtiqueta, argAyuda) {
            const objTd = document.createElement("td");
            objTd.className = "celdaBoton";
            objTd.dataset.label = argEtiqueta;
            const objBoton = document.createElement("button");
            objBoton.type = "button";
            objBoton.className = "btCelda " + argClase;
            objBoton.textContent = argTexto;
            objBoton.title = argAyuda;
            objBoton.disabled = !!argDeshabilitado;
            objBoton.onclick = argManejador;
            objTd.appendChild(objBoton);
            argFila.appendChild(objTd);
        }

        // ---------- ventanas modales ----------

        function abrirModal(argId) {
            objTablero.className = "contenedorPasivo";
            document.getElementById(argId).style.visibility = "visible";
        }

        function cerrarModalFormulario() {
            document.getElementById("ventanaModalFormulario").style.visibility = "hidden";
            // Si la respuesta tambien esta abierta, el tablero sigue pasivo
            if (document.getElementById("ventanaModalRespuesta").style.visibility !== "visible") {
                objTablero.className = "contenedorActivo";
            }
        }

        function cerrarModalRespuesta() {
            document.getElementById("ventanaModalRespuesta").style.visibility = "hidden";
            document.getElementById("contenidoModalRespuesta").innerHTML = "";
            document.getElementById("ventanaModalFormulario").style.visibility = "hidden";
            objTablero.className = "contenedorActivo";
        }

        // Muestra el texto de respuesta (puede traer HTML) en la ventana de respuestas
        function mostrarRespuesta(argEncabezado, argHtml) {
            document.getElementById("encabezadoModalRespuesta").textContent = argEncabezado;
            document.getElementById("contenidoModalRespuesta").innerHTML = argHtml;
            abrirModal("ventanaModalRespuesta");
        }

        // ---------- sucursales ----------

        // Pobla el desplegable del filtro con la tabla auxiliar (sucursales)
        function cargaSucursales() {
            fetch("./salidaJsonSucursales.php", { method: "POST" })
                .then(respuesta => respuesta.text())
                .then(texto => {
                    alert("JSON de sucursales recibido:\n" + texto);
                    objGlobalSucursales = JSON.parse(texto);
                    const objSel = document.getElementById("f_clientes_codSucursal");
                    objGlobalSucursales.sucursales.forEach(function (suc) {
                        const objOpt = document.createElement("option");
                        objOpt.value = suc.codSucursal;
                        objOpt.textContent = suc.nombreSucursal;
                        objSel.appendChild(objOpt);
                    });
                })
                .catch(error => alert("Error producido: " + error));
        }

        // Llena el desplegable del formulario y marca como selected la sucursal indicada
        function llenaSucursalesForm(argCodSeleccionado) {
            const objSel = document.getElementById("formCodSucursal");
            objSel.innerHTML = '<option value=""></option>';
            objGlobalSucursales.sucursales.forEach(function (suc) {
                const objOpt = document.createElement("option");
                objOpt.value = suc.codSucursal;
                objOpt.textContent = suc.nombreSucursal;
                if (suc.codSucursal === argCodSeleccionado) {
                    objOpt.setAttribute("selected", "selected");
                }
                objSel.appendChild(objOpt);
            });
        }

        // ---------- formulario ----------

        function leeValoresForm() {
            const objValores = {};
            campos.forEach(function (campo) {
                objValores[campo] = document.getElementById(idForm[campo]).value;
            });
            return objValores;
        }

        // Habilita el boton de envio solo si el form es valido y (en modi) algo cambio
        function todoListoParaEnvio() {
            let listo = objFormulario.checkValidity();
            if (listo && modoFormulario === "modi") {
                const actuales = leeValoresForm();
                const huboCambio = campos.some(campo => actuales[campo] !== valoresOriginales[campo]);
                const hayArchivo = document.getElementById("formFotoPuntoEntrega").files.length > 0;
                listo = huboCambio || hayArchivo;
            }
            objBtEnvio.disabled = !listo;
        }

        function abrirFormularioAlta() {
            modoFormulario = "alta";
            objFormulario.reset();
            document.getElementById("formCodCliente").readOnly = false;
            document.getElementById("tituloFormulario").textContent = "Alta de registro";
            objBtEnvio.textContent = "Enviar alta";
            llenaSucursalesForm("");
            todoListoParaEnvio();
            abrirModal("ventanaModalFormulario");
        }

        // Recibe el objeto cliente completo de la fila donde se hizo click
        function completaFichaCliente(argCliente) {
            modoFormulario = "modi";
            objFormulario.reset();
            document.getElementById("tituloFormulario").textContent = "Modificacion de " + argCliente.codCliente;
            objBtEnvio.textContent = "Enviar modificacion";
            llenaSucursalesForm(argCliente.codSucursal);
            campos.forEach(function (campo) {
                document.getElementById(idForm[campo]).value = argCliente[campo];
            });
            // La clave no se modifica: es la que identifica el registro en el WHERE
            document.getElementById("formCodCliente").readOnly = true;
            valoresOriginales = leeValoresForm();
            todoListoParaEnvio();
            abrirModal("ventanaModalFormulario");
        }

        // ---------- requerimientos ----------

        function cargaTabla() {
            // 1) y 2) vaciar el tbody y avisar que se espera respuesta
            mensajeTbody("Esperando respuesta del servidor");

            // 3) objeto con orden y filtros
            const objDatosOrdenFiltros = new URLSearchParams();
            objDatosOrdenFiltros.append("orden", document.getElementById("orden").value);
            campos.forEach(function (campo) {
                objDatosOrdenFiltros.append("f_clientes_" + campo, document.getElementById("f_clientes_" + campo).value);
            });

            alert("Datos a enviar al servidor:\n" + objDatosOrdenFiltros.toString());

            // 4) disparo del Ajax y cadena de promesas
            fetch("./salidaJsonClientes.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: objDatosOrdenFiltros,
            })
                .then(respuesta => respuesta.text())
                .then(texto => {
                    alert("JSON recibido:\n" + texto);
                    const objJson = JSON.parse(texto);

                    if (objJson.estado !== "ok") {
                        mensajeTbody("Error: " + objJson.estado);
                        return;
                    }

                    objTbDatos.innerHTML = "";
                    objJson.clientes.forEach(function (cli) {
                        const objTr = document.createElement("tr");
                        campos.forEach(function (campo) { agregarCelda(objTr, cli[campo], etiquetas[campo]); });

                        // Botones dinamicos de cada fila: foto/PDF, modi y baja
                        agregarCeldaBoton(objTr, "PDF", "btPdf", function () { verDocumento(cli.codCliente); }, !cli.tieneFoto, "Foto", "Muestra el documento o foto de " + cli.codCliente);
                        agregarCeldaBoton(objTr, "Modi", "btModi", function () { completaFichaCliente(cli); }, false, "Modis", "Modifica el registro " + cli.codCliente);
                        agregarCeldaBoton(objTr, "Borrar", "btBorrar", function () { baja(cli.codCliente); }, false, "Bajas", "Elimina el registro " + cli.codCliente);

                        objTbDatos.appendChild(objTr);
                    });
                    if (objJson.cuenta === 0) {
                        mensajeTbody("No hay registros para ese filtro");
                    }
                    document.getElementById("cuenta").value = objJson.cuenta;
                })
                .catch(error => {
                    mensajeTbody("Error de comunicacion con el servidor");
                    alert("Error producido: " + error);
                });
        }

        // Trae el binario (base64 dentro de un JSON) y lo muestra en un iframe
        function verDocumento(argCodCliente) {
            const objDatos = new URLSearchParams();
            objDatos.append("codCliente", argCodCliente);

            fetch("./traeDoc.php", { method: "POST", headers: {}, body: objDatos })
                .then(respuesta => respuesta.text())
                .then(texto => {
                    alert("Respuesta del servidor (traeDoc):\n" + texto.substring(0, 300) + (texto.length > 300 ? "..." : ""));
                    const objDato = JSON.parse(texto);
                    if (objDato.estado !== "ok") {
                        mostrarRespuesta("Documento de " + argCodCliente, objDato.estado);
                        return;
                    }
                    mostrarRespuesta("Documento de " + argCodCliente,
                        "<iframe src='data:" + objDato.mime + ";base64," + objDato.documento + "'></iframe>");
                })
                .catch(error => alert("Error producido: " + error));
        }

        // Envia el formulario completo (con el archivo) a alta.php o modi.php
        function envioFormulario() {
            const codigo = document.getElementById("formCodCliente").value;
            const esAlta = (modoFormulario === "alta");
            const pregunta = esAlta
                ? "¿Estás seguro de insertar el registro " + codigo + "?"
                : "¿Estás seguro que desea modificar el registro " + codigo + "?";
            if (!confirm(pregunta)) {
                return;
            }

            const objDatosFormulario = new FormData(objFormulario);

            fetch(esAlta ? "./alta.php" : "./modi.php", {
                method: "POST",
                headers: {},
                body: objDatosFormulario,
            })
                .then(respuesta => respuesta.text())
                .then(datos => {
                    alert("Respuesta del servidor:\n" + datos);
                    mostrarRespuesta(esAlta ? "Respuesta del servidor al alta" : "Respuesta del servidor a la modificacion", datos);
                })
                .catch(error => alert("Error producido: " + error));
        }

        function baja(argCodCliente) {
            if (!confirm("¿Estás seguro que desea eliminar el " + argCodCliente + "?")) {
                return;
            }

            const objDatos = new URLSearchParams();
            objDatos.append("codCliente", argCodCliente);

            fetch("./baja.php", { method: "POST", headers: {}, body: objDatos })
                .then(respuesta => respuesta.text())
                .then(datos => {
                    alert("Respuesta del servidor:\n" + datos);
                    mostrarRespuesta("Respuesta del servidor a la baja", datos);
                })
                .catch(error => alert("Error producido: " + error));
        }

        // ---------- eventos ----------

        document.getElementById("btCargar").addEventListener("click", cargaTabla);
        document.getElementById("btVaciar").addEventListener("click", vaciarTabla);
        document.getElementById("btLimpiar").addEventListener("click", function () {
            campos.forEach(function (campo) { document.getElementById("f_clientes_" + campo).value = ""; });
        });
        document.getElementById("btAlta").addEventListener("click", abrirFormularioAlta);
        document.getElementById("btCerrarFormulario").addEventListener("click", cerrarModalFormulario);
        document.getElementById("btCerrarRespuesta").addEventListener("click", cerrarModalRespuesta);
        objBtEnvio.addEventListener("click", envioFormulario);

        // Validacion: cada entrada del formulario revisa si ya se puede enviar
        objFormulario.addEventListener("keyup", todoListoParaEnvio);
        objFormulario.addEventListener("change", todoListoParaEnvio);

        // Click en un titulo: carga el input "orden" y pide los datos
        campos.forEach(function (campo) {
            document.getElementById("th_clientes_" + campo).addEventListener("click", function () {
                document.getElementById("orden").value = campo;
                cargaTabla();
            });
        });

        document.getElementById("btCierraSesion").addEventListener("click", function () {
            location.href = "../destruirsesion.php";
        });

        cargaSucursales();
    </script>

</body>

</html>
