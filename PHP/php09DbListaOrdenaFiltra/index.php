<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php09 - DB lista, ordena, filtra</title>

    <meta name="addsearch-category" content="PHP, MySQL, PDO, fetch, ordenamiento, filtros" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>PHP, base de datos: lista, ordena, filtra</h1>
        <p class="alumno" style="font-weight: bold;">Alumno: Santiago Cannistra</p>
    </header>

    <hr />

    <main>

        <div class="botonera">
            <button title="Botón: Carga de datos" type="button" id="btCargar">Carga de datos</button>
            <button title="Botón: Vaciar datos" type="button" id="btVaciar">Vaciar datos</button>
            <label for="orden">Orden:</label>
            <input title="Campo por el que está ordenada la tabla (se cambia haciendo click en un título de columna)" type="text" id="orden" value="codCliente" readonly />
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
                    </tr>
                    <tr class="filtros">
                        <th><input title="Filtrar por código de cliente (contiene el texto)" type="text" id="f_clientes_codCliente" /></th>
                        <th>
                            <!-- Desplegable poblado con el JSON de salidaJsonSucursales.php -->
                            <select title="Filtrar por sucursal" id="f_clientes_codSucursal">
                                <option value=""></option>
                            </select>
                        </th>
                        <th><input title="Filtrar por dirección de entrega (contiene el texto)" type="text" id="f_clientes_direccionEntrega" /></th>
                        <th><input title="Filtrar por día de entrega (por ej. Lunes)" type="text" id="f_clientes_diaSemanalEntrega" /></th>
                        <th><input title="Filtrar por costo promedio de transporte" type="text" id="f_clientes_costoPromedioTransporte" /></th>
                        <th><input title="Filtrar por fecha de última entrega, formato aaaa-mm-dd" type="text" id="f_clientes_fechaUltimaEntrega" placeholder="aaaa-mm-dd" /></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbDatos">
                    <tr id="filaVacia">
                        <td colspan="7">Todavía no se cargaron datos. Apretá "Carga de datos".</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="7">
                            Tabla: Agrupacion de datos logisticos clientes - Santiago Cannistra -
                            Registros: <input title="Cantidad de registros recibidos" type="text" id="cuenta" value="0" size="4" readonly />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </main>

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

        // Campos de la tabla: cada uno tiene un titulo clickeable (orden) y un filtro
        const campos = ["codCliente", "codSucursal", "direccionEntrega", "diaSemanalEntrega", "costoPromedioTransporte", "fechaUltimaEntrega"];

        function mensajeTbody(argTexto) {
            objTbDatos.innerHTML = "";
            const objTr = document.createElement("tr");
            objTr.id = "filaVacia";
            objTr.innerHTML = '<td colspan="7">' + argTexto + '</td>';
            objTbDatos.appendChild(objTr);
        }

        function vaciarTabla() {
            mensajeTbody('Todavía no se cargaron datos. Apretá "Carga de datos".');
            document.getElementById("cuenta").value = 0;
        }

        function agregarCelda(argFila, argValor) {
            const objTd = document.createElement("td");
            objTd.textContent = argValor;
            argFila.appendChild(objTd);
        }

        // Pobla el desplegable con la tabla auxiliar (sucursales)
        function cargaSucursales() {
            fetch("./salidaJsonSucursales.php", { method: "POST" })
                .then(respuesta => respuesta.text())
                .then(texto => {
                    alert("JSON de sucursales recibido:\n" + texto);
                    const objJson = JSON.parse(texto);
                    const objSel = document.getElementById("f_clientes_codSucursal");
                    objJson.sucursales.forEach(function (suc) {
                        const objOpt = document.createElement("option");
                        objOpt.value = suc.codSucursal;
                        objOpt.textContent = suc.nombreSucursal;
                        objSel.appendChild(objOpt);
                    });
                })
                .catch(error => alert("Error producido: " + error));
        }

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
                        campos.forEach(function (campo) { agregarCelda(objTr, cli[campo]); });
                        agregarCelda(objTr, cli.tieneFoto ? "Si" : "Sin foto");
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

        document.getElementById("btCargar").addEventListener("click", cargaTabla);
        document.getElementById("btVaciar").addEventListener("click", vaciarTabla);

        // Click en un titulo: carga el input "orden" y pide los datos
        campos.forEach(function (campo) {
            document.getElementById("th_clientes_" + campo).addEventListener("click", function () {
                document.getElementById("orden").value = campo;
                cargaTabla();
            });
        });

        cargaSucursales();
    </script>

</body>

</html>
