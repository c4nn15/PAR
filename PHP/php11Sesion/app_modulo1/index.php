<?php include "../manejoSesion.inc"; ?>
<!DOCTYPE html>

<!-- [ESTUDIO] raiz del documento; lang=es indica idioma espanol -->
<html lang="es">

<!-- [ESTUDIO] HEAD: metadatos, titulo y estilos (no se ve en pantalla) -->
<head>
    <!-- [ESTUDIO] codificacion de caracteres UTF-8 (acentos y enie) -->
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
    <!-- [ESTUDIO] viewport: hace que la pagina se adapte al ancho del celular -->
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <!-- [ESTUDIO] titulo que aparece en la pestana del navegador -->
    <title>php10 - ABM</title>

    <!-- [ESTUDIO] metadato de busqueda con las palabras clave del ejercicio -->
    <meta name="addsearch-category" content="PHP, MySQL, PDO, fetch, ABM, CRUD, binarios" />

    <!-- [ESTUDIO] vincula la hoja de estilos externa estilo.css -->
    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<!-- [ESTUDIO] BODY: todo lo que se ve en pantalla -->
<body>

    <!-- [ESTUDIO] cabecera de la pagina -->
    <header>
        <h1>PHP, sesión: ABM de clientes</h1>
        <p class="alumno">Alumno: Santiago Cannistra</p>
    </header>

    <!-- [ESTUDIO] linea horizontal separadora -->
    <hr />

    <!-- [ESTUDIO] MAIN: contenedor de la tabla. La clase contenedorActivo/Pasivo se cambia por JS para bloquear la tabla cuando hay un modal abierto -->
    <main id="contenedorTablaClientes" class="contenedorActivo">

        <!-- [ESTUDIO] botonera: botones de accion de la tabla -->
        <div class="botonera">
            <!-- [ESTUDIO] btCargar: pide los registros al servidor (llama a cargaTabla) -->
            <button type="button" id="btCargar" title="Trae los registros del servidor aplicando el orden y los filtros actuales">Carga de datos</button>
            <!-- [ESTUDIO] btVaciar: vacia la tabla sin consultar al servidor -->
            <button type="button" id="btVaciar" title="Vacía la tabla sin consultar al servidor">Vaciar datos</button>
            <!-- [ESTUDIO] btLimpiar: borra el contenido de los filtros -->
            <button type="button" id="btLimpiar" title="Borra el contenido de todos los filtros">Limpiar filtros</button>
            <!-- [ESTUDIO] btAlta: abre el formulario para un alta nueva -->
            <button type="button" id="btAlta" title="Abre el formulario para dar de alta un nuevo cliente">Alta registro</button>
            <!-- [ESTUDIO] btCierraSesion (agregado en PHP 11): al click redirige a ../destruirsesion.php -->
            <button type="button" id="btCierraSesion" title="Cierra la sesión y vuelve al login">Cerrar sesión</button>
            <!-- [ESTUDIO] label asociada al input 'orden' (for = id del input) -->
            <label for="orden">Orden:</label>
            <!-- [ESTUDIO] input de solo lectura que guarda el campo de orden actual (por defecto codCliente) -->
            <input type="text" id="orden" value="codCliente" title="Campo por el que está ordenada la tabla (se cambia haciendo click en un título de columna)" readonly />
        </div>

        <!-- [ESTUDIO] contenedor con scroll para que la tabla no desborde en pantallas chicas -->
        <div class="tablaScroll">
            <!-- [ESTUDIO] inicio de la tabla -->
            <table>
                <!-- [ESTUDIO] THEAD: encabezado de la tabla -->
                <thead>
                    <!-- [ESTUDIO] fila de titulos: al hacer click en uno se ordena por esa columna -->
                    <tr class="titulos">
                        <th id="th_clientes_codCliente">Cod. cliente</th>
                        <th id="th_clientes_codSucursal">Sucursal</th>
                        <th id="th_clientes_direccionEntrega">Direccion de entrega</th>
                        <th id="th_clientes_diaSemanalEntrega">Dia de entrega</th>
                        <th id="th_clientes_costoPromedioTransporte">Costo transporte</th>
                        <th id="th_clientes_fechaUltimaEntrega">Ultima entrega</th>
                        <!-- [ESTUDIO] columna Foto: sin orden (solo botones) -->
                        <th>Foto</th>
                        <th>Modis</th>
                        <th>Bajas</th>
                    </tr>
                    <!-- [ESTUDIO] fila de filtros: un input/select por columna -->
                    <tr class="filtros">
                        <!-- [ESTUDIO] filtro de texto por codCliente; su id es el que lee el JS (f_clientes_ + campo) -->
                        <th><input type="text" id="f_clientes_codCliente" title="Filtrar por código de cliente (contiene el texto)" /></th>
                        <th>
                            <!-- [ESTUDIO] (comentario original) el select se llena con el JSON de salidaJsonSucursales.php -->
                            <!-- Desplegable poblado con el JSON de salidaJsonSucursales.php -->
                            <!-- [ESTUDIO] filtro desplegable por sucursal -->
                            <select id="f_clientes_codSucursal" title="Filtrar por sucursal">
                                <!-- [ESTUDIO] opcion vacia = sin filtro -->
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
                <!-- [ESTUDIO] TBODY: aqui el JS inserta las filas de datos -->
                <tbody id="tbDatos">
                    <!-- [ESTUDIO] fila inicial con el mensaje de tabla vacia; colspan=9 ocupa las 9 columnas -->
                    <tr id="filaVacia">
                        <td colspan="9">Todavía no se cargaron datos. Apretá "Carga de datos".</td>
                    </tr>
                </tbody>
                <!-- [ESTUDIO] TFOOT: pie de la tabla -->
                <tfoot>
                    <tr>
                        <td colspan="9">
                            Tabla: Agrupacion de datos logisticos clientes - Santiago Cannistra -
                            <!-- [ESTUDIO] muestra la cantidad de registros recibidos (solo lectura) -->
                            Registros: <input type="text" id="cuenta" value="0" size="4" title="Cantidad de registros recibidos" readonly />
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

    </main>

    <!-- [ESTUDIO] (comentario original) modal del formulario, sirve para alta y modi -->
    <!-- Ventana modal del formulario (sirve para alta y para modi) -->
    <!-- [ESTUDIO] capa que cubre la pantalla; se muestra/oculta cambiando style.visibility desde JS -->
    <div id="ventanaModalFormulario" class="ventanaModal">
        <!-- [ESTUDIO] caja blanca central del modal -->
        <div class="modalCaja">
            <div class="modalEncabezado">
                <span id="tituloFormulario">Formulario</span>
                <!-- [ESTUDIO] cierra el formulario sin enviar -->
                <button type="button" id="btCerrarFormulario" class="btCelda" title="Cierra el formulario sin enviar">Cerrar</button>
            </div>

            <!-- [ESTUDIO] formulario de alta/modi. enctype=multipart/form-data es OBLIGATORIO para poder subir archivos. No tiene action: el envio lo hace fetch desde JS -->
            <form id="formClientes" method="post" enctype="multipart/form-data">
                <ul>
                    <li>
                        <label for="formCodCliente">Cod. cliente:</label>
                        <!-- [ESTUDIO] codCliente: name es la clave que llega a PHP en $_POST['codCliente']; required = obligatorio; maxlength = largo maximo -->
                        <input type="text" id="formCodCliente" name="codCliente" maxlength="10" title="Código único del cliente, hasta 10 caracteres (no se puede cambiar en una modificación)" required />
                    </li>
                    <li>
                        <label for="formCodSucursal">Sucursal:</label>
                        <!-- [ESTUDIO] select de sucursal; sus opciones las genera el JS (llenaSucursalesForm) -->
                        <select id="formCodSucursal" name="codSucursal" title="Sucursal que atiende al cliente" required></select>
                    </li>
                    <li>
                        <label for="formDireccionEntrega">Direccion de entrega:</label>
                        <input type="text" id="formDireccionEntrega" name="direccionEntrega" maxlength="100" title="Dirección donde se entrega la mercadería, hasta 100 caracteres" required />
                    </li>
                    <li>
                        <label for="formDiaSemanalEntrega">Dia de entrega:</label>
                        <!-- [ESTUDIO] select de dia de la semana con valores fijos -->
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
                        <!-- [ESTUDIO] type=number: solo numeros; min=0 y step=any permiten decimales no negativos -->
                        <input type="number" id="formCostoPromedioTransporte" name="costoPromedioTransporte" min="0" step="any" title="Costo promedio de transporte, número mayor o igual a 0" required />
                    </li>
                    <li>
                        <label for="formFechaUltimaEntrega">Ultima entrega:</label>
                        <!-- [ESTUDIO] type=date: selector de fecha, envia formato aaaa-mm-dd -->
                        <input type="date" id="formFechaUltimaEntrega" name="fechaUltimaEntrega" title="Fecha de la última entrega realizada" required />
                    </li>
                    <li>
                        <label for="formFotoPuntoEntrega">Foto / documento:</label>
                        <!-- [ESTUDIO] type=file: archivo opcional; llega a PHP en $_FILES['fotoPuntoEntrega'] -->
                        <input type="file" id="formFotoPuntoEntrega" name="fotoPuntoEntrega" title="Foto o documento del punto de entrega (opcional)" />
                    </li>
                </ul>
            </form>

            <div class="modalPie">
                <!-- [ESTUDIO] boton Enviar; nace disabled y el JS lo habilita cuando el formulario es valido -->
                <button type="button" id="btEnvioForm" title="Envía el formulario al servidor; se habilita cuando los datos son válidos" disabled>Enviar</button>
            </div>
        </div>
    </div>

    <!-- [ESTUDIO] (comentario original) segundo modal: muestra resultados de alta/modi/baja y el PDF/foto -->
    <!-- Ventana modal de respuestas del servidor (PDF/foto, resultado de alta, modi y baja) -->
    <div id="ventanaModalRespuesta" class="ventanaModal">
        <div class="modalCaja">
            <div class="modalEncabezado">
                <span id="encabezadoModalRespuesta">Respuesta del servidor</span>
                <button type="button" id="btCerrarRespuesta" class="btCelda" title="Cierra la ventana de respuesta">Cerrar</button>
            </div>
            <!-- [ESTUDIO] aqui el JS escribe el HTML de respuesta (innerHTML) -->
            <div id="contenidoModalRespuesta"></div>
        </div>
    </div>

    <hr />

    <!-- [ESTUDIO] pie de pagina -->
    <footer>
        <!-- [ESTUDIO] enlace para volver al indice -->
        <p><a href="../../index.html">Volver al indice de PHP</a></p>

        Santiago Cannistra
        <address>
            Programación en Ambiente de Redes
        </address>
    </footer>

    <!-- [ESTUDIO] SCRIPT: logica de la pagina (JavaScript) -->
    <script>
        // [ESTUDIO] referencia al tbody de datos (getElementById busca por id)
        const objTbDatos = document.getElementById("tbDatos");
        // [ESTUDIO] referencia al contenedor principal (para cambiarle la clase)
        const objTablero = document.getElementById("contenedorTablaClientes");
        // [ESTUDIO] referencia al formulario del modal
        const objFormulario = document.getElementById("formClientes");
        // [ESTUDIO] referencia al boton Enviar del formulario
        const objBtEnvio = document.getElementById("btEnvioForm");

        // [ESTUDIO] (comentario original) campos de la tabla; sirve para armar ids por concatenacion
        // Campos de la tabla: cada uno tiene un titulo clickeable (orden) y un filtro
        // [ESTUDIO] arreglo con los nombres de campo; se recorre con forEach para no repetir codigo
        const campos = ["codCliente", "codSucursal", "direccionEntrega", "diaSemanalEntrega", "costoPromedioTransporte", "fechaUltimaEntrega"];

        // [ESTUDIO] (comentario original) id del input del formulario correspondiente a cada campo
        // Campo del formulario (id) de cada campo de la tabla
        // [ESTUDIO] objeto (diccionario): clave = campo de la tabla, valor = id del input del formulario
        const idForm = {
            codCliente: "formCodCliente",
            codSucursal: "formCodSucursal",
            direccionEntrega: "formDireccionEntrega",
            diaSemanalEntrega: "formDiaSemanalEntrega",
            costoPromedioTransporte: "formCostoPromedioTransporte",
            fechaUltimaEntrega: "formFechaUltimaEntrega",
        };

        // [ESTUDIO] (comentario original) etiquetas de cada campo
        // Titulo de cada campo (etiqueta de las celdas en pantallas chicas)
        // [ESTUDIO] objeto con los titulos; se usan en data-label para pantallas chicas
        const etiquetas = {
            codCliente: "Cod. cliente",
            codSucursal: "Sucursal",
            direccionEntrega: "Direccion de entrega",
            diaSemanalEntrega: "Dia de entrega",
            costoPromedioTransporte: "Costo transporte",
            fechaUltimaEntrega: "Ultima entrega",
        };

        // [ESTUDIO] (comentario original) lista de sucursales compartida por filtro y formulario
        // Lista de sucursales: la usan el filtro y el formulario
        // [ESTUDIO] variable global (let); empieza con arreglo vacio y se completa al llegar el JSON
        let objGlobalSucursales = { sucursales: [] };

        // [ESTUDIO] (comentario original) modo del formulario
        // "alta" o "modi": define a que script se envia el formulario
        // [ESTUDIO] 'alta' o 'modi': decide si se envia a alta.php o modi.php
        let modoFormulario = "alta";

        // [ESTUDIO] (comentario original) valores originales para detectar cambios
        // Valores del registro al abrir la modi, para detectar si cambio algo
        // [ESTUDIO] se guarda una foto de los valores al abrir la modificacion
        let valoresOriginales = {};

        // [ESTUDIO] muestra un mensaje de una sola fila en la tabla (cargando, vacio, error)
        function mensajeTbody(argTexto) {
            // [ESTUDIO] vacia el tbody
            objTbDatos.innerHTML = "";
            // [ESTUDIO] crea un elemento <tr> nuevo en memoria
            const objTr = document.createElement("tr");
            // [ESTUDIO] le pone el id filaVacia
            objTr.id = "filaVacia";
            // [ESTUDIO] el contenido es una celda que ocupa las 9 columnas con el texto recibido
            objTr.innerHTML = '<td colspan="9">' + argTexto + '</td>';
            // [ESTUDIO] agrega la fila al tbody (recien ahi se ve)
            objTbDatos.appendChild(objTr);
        }

        // [ESTUDIO] deja la tabla como al inicio, sin ir al servidor
        function vaciarTabla() {
            // [ESTUDIO] muestra el mensaje inicial
            mensajeTbody('Todavía no se cargaron datos. Apretá "Carga de datos".');
            // [ESTUDIO] pone el contador de registros en 0
            document.getElementById("cuenta").value = 0;
        }

        // [ESTUDIO] agrega una celda de texto a una fila
        function agregarCelda(argFila, argValor, argEtiqueta) {
            // [ESTUDIO] crea el <td>
            const objTd = document.createElement("td");
            // [ESTUDIO] data-label: texto que usa el CSS en celulares
            objTd.dataset.label = argEtiqueta;
            // [ESTUDIO] textContent inserta el valor como texto plano (no interpreta HTML: seguro)
            objTd.textContent = argValor;
            // [ESTUDIO] agrega la celda a la fila
            argFila.appendChild(objTd);
        }

        // [ESTUDIO] (comentario original) crea una celda con un boton y su manejador de click
        // Crea una celda con un boton y le asigna el manejador de click
        function agregarCeldaBoton(argFila, argTexto, argClase, argManejador, argDeshabilitado, argEtiqueta, argAyuda) {
            // [ESTUDIO] crea la celda
            const objTd = document.createElement("td");
            // [ESTUDIO] clase CSS de celda de boton
            objTd.className = "celdaBoton";
            // [ESTUDIO] etiqueta para vista celular
            objTd.dataset.label = argEtiqueta;
            // [ESTUDIO] crea el <button>
            const objBoton = document.createElement("button");
            // [ESTUDIO] type=button: evita que envie formularios
            objBoton.type = "button";
            // [ESTUDIO] clases CSS: base + especifica (btPdf, btModi, btBorrar)
            objBoton.className = "btCelda " + argClase;
            // [ESTUDIO] texto visible del boton
            objBoton.textContent = argTexto;
            // [ESTUDIO] tooltip (title)
            objBoton.title = argAyuda;
            // [ESTUDIO] !! convierte a booleano: deshabilita el boton si corresponde (ej. PDF sin foto)
            objBoton.disabled = !!argDeshabilitado;
            // [ESTUDIO] asigna la funcion que se ejecuta al hacer click
            objBoton.onclick = argManejador;
            // [ESTUDIO] mete el boton en la celda
            objTd.appendChild(objBoton);
            // [ESTUDIO] mete la celda en la fila
            argFila.appendChild(objTd);
        }

        // [ESTUDIO] (comentario original) seccion de ventanas modales
        // ---------- ventanas modales ----------

        // [ESTUDIO] muestra un modal por su id
        function abrirModal(argId) {
            // [ESTUDIO] pone la tabla en estado pasivo (CSS la bloquea)
            objTablero.className = "contenedorPasivo";
            // [ESTUDIO] visibility: visible = muestra el modal
            document.getElementById(argId).style.visibility = "visible";
        }

        // [ESTUDIO] cierra solo el modal del formulario
        function cerrarModalFormulario() {
            // [ESTUDIO] visibility: hidden = oculta el modal
            document.getElementById("ventanaModalFormulario").style.visibility = "hidden";
            // Si la respuesta tambien esta abierta, el tablero sigue pasivo
            // [ESTUDIO] si el modal de respuesta NO esta visible...
            if (document.getElementById("ventanaModalRespuesta").style.visibility !== "visible") {
                // [ESTUDIO] ...la tabla vuelve a estar activa
                objTablero.className = "contenedorActivo";
            }
        }

        // [ESTUDIO] cierra el modal de respuesta (y tambien el del formulario)
        function cerrarModalRespuesta() {
            // [ESTUDIO] oculta el modal de respuesta
            document.getElementById("ventanaModalRespuesta").style.visibility = "hidden";
            // [ESTUDIO] borra el contenido que habia mostrado
            document.getElementById("contenidoModalRespuesta").innerHTML = "";
            // [ESTUDIO] oculta tambien el formulario
            document.getElementById("ventanaModalFormulario").style.visibility = "hidden";
            // [ESTUDIO] reactiva la tabla
            objTablero.className = "contenedorActivo";
        }

        // Muestra el texto de respuesta (puede traer HTML) en la ventana de respuestas
        // [ESTUDIO] muestra un titulo y un HTML en el modal de respuesta
        function mostrarRespuesta(argEncabezado, argHtml) {
            // [ESTUDIO] textContent: el titulo va como texto
            document.getElementById("encabezadoModalRespuesta").textContent = argEncabezado;
            // [ESTUDIO] innerHTML: el contenido SI se interpreta como HTML (viene del servidor)
            document.getElementById("contenidoModalRespuesta").innerHTML = argHtml;
            // [ESTUDIO] abre el modal de respuesta
            abrirModal("ventanaModalRespuesta");
        }

        // [ESTUDIO] (comentario original) seccion sucursales
        // ---------- sucursales ----------

        // Pobla el desplegable del filtro con la tabla auxiliar (sucursales)
        // [ESTUDIO] pide las sucursales al servidor para poblar el filtro
        function cargaSucursales() {
            // [ESTUDIO] fetch: peticion HTTP asincrona (AJAX) por POST a salidaJsonSucursales.php; devuelve una promesa
            fetch("./salidaJsonSucursales.php", { method: "POST" })
                // [ESTUDIO] primer then: convierte la respuesta HTTP en texto
                .then(respuesta => respuesta.text())
                // [ESTUDIO] segundo then: recibe el texto cuando esta listo
                .then(texto => {
                    // [ESTUDIO] alert de depuracion: muestra el JSON crudo recibido
                    alert("JSON de sucursales recibido:\n" + texto);
                    // [ESTUDIO] JSON.parse: texto JSON -> objeto JavaScript
                    objGlobalSucursales = JSON.parse(texto);
                    // [ESTUDIO] referencia al select del filtro
                    const objSel = document.getElementById("f_clientes_codSucursal");
                    // [ESTUDIO] forEach: recorre cada sucursal del arreglo
                    objGlobalSucursales.sucursales.forEach(function (suc) {
                        // [ESTUDIO] crea un <option>
                        const objOpt = document.createElement("option");
                        // [ESTUDIO] value = codigo de sucursal (lo que se envia)
                        objOpt.value = suc.codSucursal;
                        // [ESTUDIO] texto visible = nombre de la sucursal
                        objOpt.textContent = suc.nombreSucursal;
                        // [ESTUDIO] agrega la opcion al select
                        objSel.appendChild(objOpt);
                    });
                })
                // [ESTUDIO] catch: captura errores de red o de JSON.parse
                .catch(error => alert("Error producido: " + error));
        }

        // Llena el desplegable del formulario y marca como selected la sucursal indicada
        // [ESTUDIO] llena el select del formulario y deja marcada la sucursal indicada
        function llenaSucursalesForm(argCodSeleccionado) {
            // [ESTUDIO] referencia al select del formulario
            const objSel = document.getElementById("formCodSucursal");
            // [ESTUDIO] lo reinicia con una opcion vacia
            objSel.innerHTML = '<option value=""></option>';
            // [ESTUDIO] recorre las sucursales
            objGlobalSucursales.sucursales.forEach(function (suc) {
                // [ESTUDIO] crea la opcion
                const objOpt = document.createElement("option");
                // [ESTUDIO] value = codigo
                objOpt.value = suc.codSucursal;
                // [ESTUDIO] texto = nombre
                objOpt.textContent = suc.nombreSucursal;
                // [ESTUDIO] si es la sucursal del registro que se modifica...
                if (suc.codSucursal === argCodSeleccionado) {
                    // [ESTUDIO] ...se marca como seleccionada
                    objOpt.setAttribute("selected", "selected");
                }
                // [ESTUDIO] agrega la opcion al select
                objSel.appendChild(objOpt);
            });
        }

        // [ESTUDIO] (comentario original) seccion formulario
        // ---------- formulario ----------

        // [ESTUDIO] lee los valores actuales del formulario
        function leeValoresForm() {
            // [ESTUDIO] objeto vacio donde se guardan
            const objValores = {};
            // [ESTUDIO] recorre cada campo
            campos.forEach(function (campo) {
                // [ESTUDIO] toma el value del input usando el mapa idForm
                objValores[campo] = document.getElementById(idForm[campo]).value;
            });
            // [ESTUDIO] devuelve el objeto con los valores
            return objValores;
        }

        // [ESTUDIO] (comentario original) habilita Enviar solo si el form es valido y, en modi, hubo cambios
        // Habilita el boton de envio solo si el form es valido y (en modi) algo cambio
        function todoListoParaEnvio() {
            // [ESTUDIO] checkValidity: true si se cumplen required, maxlength, type, etc.
            let listo = objFormulario.checkValidity();
            // [ESTUDIO] si es valido y estamos modificando...
            if (listo && modoFormulario === "modi") {
                // [ESTUDIO] lee lo que hay ahora en el form
                const actuales = leeValoresForm();
                // [ESTUDIO] some: true si AL MENOS un campo difiere del original
                const huboCambio = campos.some(campo => actuales[campo] !== valoresOriginales[campo]);
                // [ESTUDIO] true si se eligio un archivo nuevo
                const hayArchivo = document.getElementById("formFotoPuntoEntrega").files.length > 0;
                // [ESTUDIO] se puede enviar si hubo cambio o archivo
                listo = huboCambio || hayArchivo;
            }
            // [ESTUDIO] disabled = lo contrario de 'listo'
            objBtEnvio.disabled = !listo;
        }

        // [ESTUDIO] prepara el formulario para un alta
        function abrirFormularioAlta() {
            // [ESTUDIO] modo alta: el envio ira a alta.php
            modoFormulario = "alta";
            // [ESTUDIO] reset: limpia todos los campos
            objFormulario.reset();
            // [ESTUDIO] en alta la clave SI se puede escribir
            document.getElementById("formCodCliente").readOnly = false;
            // [ESTUDIO] cambia el titulo del modal
            document.getElementById("tituloFormulario").textContent = "Alta de registro";
            // [ESTUDIO] cambia el texto del boton Enviar
            objBtEnvio.textContent = "Enviar alta";
            // [ESTUDIO] llena las sucursales sin ninguna seleccionada
            llenaSucursalesForm("");
            // [ESTUDIO] evalua si habilita el boton
            todoListoParaEnvio();
            // [ESTUDIO] muestra el modal del formulario
            abrirModal("ventanaModalFormulario");
        }

        // [ESTUDIO] (comentario original) recibe el cliente completo de la fila clickeada
        // Recibe el objeto cliente completo de la fila donde se hizo click
        function completaFichaCliente(argCliente) {
            // [ESTUDIO] modo modificacion: el envio ira a modi.php
            modoFormulario = "modi";
            // [ESTUDIO] limpia el formulario
            objFormulario.reset();
            // [ESTUDIO] titulo con el codigo del cliente
            document.getElementById("tituloFormulario").textContent = "Modificacion de " + argCliente.codCliente;
            // [ESTUDIO] texto del boton
            objBtEnvio.textContent = "Enviar modificacion";
            // [ESTUDIO] llena sucursales marcando la del cliente
            llenaSucursalesForm(argCliente.codSucursal);
            // [ESTUDIO] recorre los campos...
            campos.forEach(function (campo) {
                // [ESTUDIO] ...y copia el valor del cliente al input correspondiente
                document.getElementById(idForm[campo]).value = argCliente[campo];
            });
            // [ESTUDIO] (comentario original) la clave no se modifica
            // La clave no se modifica: es la que identifica el registro en el WHERE
            // [ESTUDIO] readOnly: la clave no se puede editar (se usa en el WHERE de modi.php)
            document.getElementById("formCodCliente").readOnly = true;
            // [ESTUDIO] guarda los valores originales para detectar cambios
            valoresOriginales = leeValoresForm();
            // [ESTUDIO] evalua si habilita Enviar
            todoListoParaEnvio();
            // [ESTUDIO] muestra el modal
            abrirModal("ventanaModalFormulario");
        }

        // [ESTUDIO] (comentario original) seccion requerimientos al servidor
        // ---------- requerimientos ----------

        // [ESTUDIO] pide los registros a salidaJsonClientes.php segun orden y filtros
        function cargaTabla() {
            // [ESTUDIO] (comentario original) pasos 1 y 2
            // 1) y 2) vaciar el tbody y avisar que se espera respuesta
            // [ESTUDIO] vacia la tabla y muestra el aviso de espera
            mensajeTbody("Esperando respuesta del servidor");

            // [ESTUDIO] (comentario original) paso 3
            // 3) objeto con orden y filtros
            // [ESTUDIO] URLSearchParams: arma los pares clave=valor para enviar
            const objDatosOrdenFiltros = new URLSearchParams();
            // [ESTUDIO] agrega el campo de orden
            objDatosOrdenFiltros.append("orden", document.getElementById("orden").value);
            // [ESTUDIO] recorre los campos
            campos.forEach(function (campo) {
                // [ESTUDIO] agrega cada filtro con el nombre que espera PHP (f_clientes_ + campo)
                objDatosOrdenFiltros.append("f_clientes_" + campo, document.getElementById("f_clientes_" + campo).value);
            });

            // [ESTUDIO] alert de depuracion con lo que se va a enviar
            alert("Datos a enviar al servidor:\n" + objDatosOrdenFiltros.toString());

            // [ESTUDIO] (comentario original) paso 4: fetch y cadena de promesas
            // 4) disparo del Ajax y cadena de promesas
            // [ESTUDIO] POST a salidaJsonClientes.php
            fetch("./salidaJsonClientes.php", {
                // [ESTUDIO] POST
                method: "POST",
                // [ESTUDIO] indica que el cuerpo va como formulario urlencoded (para $_POST)
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                // [ESTUDIO] cuerpo: los parametros armados
                body: objDatosOrdenFiltros,
            })
                // [ESTUDIO] convierte la respuesta a texto
                .then(respuesta => respuesta.text())
                // [ESTUDIO] cuando el texto esta listo...
                .then(texto => {
                    // [ESTUDIO] alert de depuracion con el JSON crudo
                    alert("JSON recibido:\n" + texto);
                    // [ESTUDIO] texto -> objeto JS
                    const objJson = JSON.parse(texto);

                    // [ESTUDIO] si PHP informo error en 'estado'...
                    if (objJson.estado !== "ok") {
                        // [ESTUDIO] ...se muestra en la tabla
                        mensajeTbody("Error: " + objJson.estado);
                        // [ESTUDIO] return: corta la funcion
                        return;
                    }

                    // [ESTUDIO] vacia el tbody
                    objTbDatos.innerHTML = "";
                    // [ESTUDIO] recorre cada cliente recibido
                    objJson.clientes.forEach(function (cli) {
                        // [ESTUDIO] crea la fila
                        const objTr = document.createElement("tr");
                        // [ESTUDIO] crea las 6 celdas de datos de la fila
                        campos.forEach(function (campo) { agregarCelda(objTr, cli[campo], etiquetas[campo]); });

                        // [ESTUDIO] (comentario original) botones de cada fila
                        // Botones dinamicos de cada fila: foto/PDF, modi y baja
                        // [ESTUDIO] boton PDF: deshabilitado si el cliente no tiene foto; al click llama a verDocumento
                        agregarCeldaBoton(objTr, "PDF", "btPdf", function () { verDocumento(cli.codCliente); }, !cli.tieneFoto, "Foto", "Muestra el documento o foto de " + cli.codCliente);
                        // [ESTUDIO] boton Modi: al click abre el formulario con los datos de esa fila
                        agregarCeldaBoton(objTr, "Modi", "btModi", function () { completaFichaCliente(cli); }, false, "Modis", "Modifica el registro " + cli.codCliente);
                        // [ESTUDIO] boton Borrar: al click llama a baja
                        agregarCeldaBoton(objTr, "Borrar", "btBorrar", function () { baja(cli.codCliente); }, false, "Bajas", "Elimina el registro " + cli.codCliente);

                        // [ESTUDIO] agrega la fila a la tabla
                        objTbDatos.appendChild(objTr);
                    });
                    // [ESTUDIO] si no vino ningun registro...
                    if (objJson.cuenta === 0) {
                        // [ESTUDIO] ...avisa que no hay datos para ese filtro
                        mensajeTbody("No hay registros para ese filtro");
                    }
                    // [ESTUDIO] muestra la cantidad de registros
                    document.getElementById("cuenta").value = objJson.cuenta;
                })
                // [ESTUDIO] error de red o JSON invalido
                .catch(error => {
                    // [ESTUDIO] muestra mensaje en la tabla
                    mensajeTbody("Error de comunicacion con el servidor");
                    // [ESTUDIO] alert con el error
                    alert("Error producido: " + error);
                });
        }

        // [ESTUDIO] (comentario original) pide el binario y lo muestra en un iframe
        // Trae el binario (base64 dentro de un JSON) y lo muestra en un iframe
        // [ESTUDIO] recibe el codigo del cliente
        function verDocumento(argCodCliente) {
            // [ESTUDIO] parametros a enviar
            const objDatos = new URLSearchParams();
            // [ESTUDIO] agrega codCliente
            objDatos.append("codCliente", argCodCliente);

            // [ESTUDIO] POST a traeDoc.php
            fetch("./traeDoc.php", { method: "POST", headers: {}, body: objDatos })
                // [ESTUDIO] respuesta -> texto
                .then(respuesta => respuesta.text())
                .then(texto => {
                    // [ESTUDIO] alert de depuracion (recorta el texto a 300 caracteres porque el base64 es enorme)
                    alert("Respuesta del servidor (traeDoc):\n" + texto.substring(0, 300) + (texto.length > 300 ? "..." : ""));
                    // [ESTUDIO] texto -> objeto
                    const objDato = JSON.parse(texto);
                    // [ESTUDIO] si el estado no es ok...
                    if (objDato.estado !== "ok") {
                        // [ESTUDIO] ...muestra el motivo en el modal
                        mostrarRespuesta("Documento de " + argCodCliente, objDato.estado);
                        // [ESTUDIO] corta
                        return;
                    }
                    // [ESTUDIO] muestra el documento en el modal
                    mostrarRespuesta("Documento de " + argCodCliente,
                        // [ESTUDIO] data URI: el iframe muestra el archivo directamente desde el base64, sin pedir otro archivo al servidor
                        "<iframe src='data:" + objDato.mime + ";base64," + objDato.documento + "'></iframe>");
                })
                // [ESTUDIO] captura errores
                .catch(error => alert("Error producido: " + error));
        }

        // [ESTUDIO] (comentario original) envia el formulario completo a alta.php o modi.php
        // Envia el formulario completo (con el archivo) a alta.php o modi.php
        function envioFormulario() {
            // [ESTUDIO] toma el codigo escrito en el formulario
            const codigo = document.getElementById("formCodCliente").value;
            // [ESTUDIO] true si estamos en modo alta
            const esAlta = (modoFormulario === "alta");
            // [ESTUDIO] arma el texto de confirmacion segun el modo (operador ternario)
            const pregunta = esAlta
                ? "¿Estás seguro de insertar el registro " + codigo + "?"
                : "¿Estás seguro que desea modificar el registro " + codigo + "?";
            // [ESTUDIO] confirm: ventana Aceptar/Cancelar; si cancela...
            if (!confirm(pregunta)) {
                // [ESTUDIO] ...se aborta el envio
                return;
            }

            // [ESTUDIO] FormData: toma todos los campos del form, incluido el archivo (por eso se usa en vez de URLSearchParams)
            const objDatosFormulario = new FormData(objFormulario);

            // [ESTUDIO] elige el script segun el modo y envia por POST
            fetch(esAlta ? "./alta.php" : "./modi.php", {
                // [ESTUDIO] POST
                method: "POST",
                // [ESTUDIO] sin Content-Type manual: el navegador pone multipart con su boundary
                headers: {},
                // [ESTUDIO] cuerpo = FormData
                body: objDatosFormulario,
            })
                // [ESTUDIO] respuesta -> texto
                .then(respuesta => respuesta.text())
                // [ESTUDIO] cuando llega el texto (HTML de estado de PHP)...
                .then(datos => {
                    // [ESTUDIO] alert de depuracion
                    alert("Respuesta del servidor:\n" + datos);
                    // [ESTUDIO] lo muestra en el modal de respuesta
                    mostrarRespuesta(esAlta ? "Respuesta del servidor al alta" : "Respuesta del servidor a la modificacion", datos);
                })
                // [ESTUDIO] captura errores
                .catch(error => alert("Error producido: " + error));
        }

        // [ESTUDIO] pide la baja de un cliente
        function baja(argCodCliente) {
            // [ESTUDIO] pide confirmacion; si cancela no hace nada
            if (!confirm("¿Estás seguro que desea eliminar el " + argCodCliente + "?")) {
                return;
            }

            // [ESTUDIO] parametros a enviar
            const objDatos = new URLSearchParams();
            // [ESTUDIO] agrega codCliente
            objDatos.append("codCliente", argCodCliente);

            // [ESTUDIO] POST a baja.php
            fetch("./baja.php", { method: "POST", headers: {}, body: objDatos })
                // [ESTUDIO] respuesta -> texto
                .then(respuesta => respuesta.text())
                // [ESTUDIO] cuando llega...
                .then(datos => {
                    // [ESTUDIO] alert de depuracion
                    alert("Respuesta del servidor:\n" + datos);
                    // [ESTUDIO] muestra el resultado en el modal
                    mostrarRespuesta("Respuesta del servidor a la baja", datos);
                })
                // [ESTUDIO] captura errores
                .catch(error => alert("Error producido: " + error));
        }

        // [ESTUDIO] (comentario original) seccion eventos: aca se conectan botones con funciones
        // ---------- eventos ----------

        // [ESTUDIO] click en Carga de datos -> cargaTabla
        document.getElementById("btCargar").addEventListener("click", cargaTabla);
        // [ESTUDIO] click en Vaciar -> vaciarTabla
        document.getElementById("btVaciar").addEventListener("click", vaciarTabla);
        // [ESTUDIO] click en Limpiar filtros: funcion anonima...
        document.getElementById("btLimpiar").addEventListener("click", function () {
            // [ESTUDIO] ...pone cada filtro en vacio
            campos.forEach(function (campo) { document.getElementById("f_clientes_" + campo).value = ""; });
        });
        // [ESTUDIO] click en Alta -> abrirFormularioAlta
        document.getElementById("btAlta").addEventListener("click", abrirFormularioAlta);
        // [ESTUDIO] click en Cerrar (formulario)
        document.getElementById("btCerrarFormulario").addEventListener("click", cerrarModalFormulario);
        // [ESTUDIO] click en Cerrar (respuesta)
        document.getElementById("btCerrarRespuesta").addEventListener("click", cerrarModalRespuesta);
        // [ESTUDIO] click en Enviar -> envioFormulario
        objBtEnvio.addEventListener("click", envioFormulario);

        // [ESTUDIO] (comentario original) validacion en vivo
        // Validacion: cada entrada del formulario revisa si ya se puede enviar
        // [ESTUDIO] cada tecla pulsada revalida el formulario
        objFormulario.addEventListener("keyup", todoListoParaEnvio);
        // [ESTUDIO] change: tambien revalida al elegir select, fecha o archivo
        objFormulario.addEventListener("change", todoListoParaEnvio);

        // [ESTUDIO] (comentario original) click en un titulo ordena
        // Click en un titulo: carga el input "orden" y pide los datos
        // [ESTUDIO] recorre los campos
        campos.forEach(function (campo) {
            // [ESTUDIO] agrega un click a cada titulo de columna
            document.getElementById("th_clientes_" + campo).addEventListener("click", function () {
                // [ESTUDIO] carga el campo clickeado en el input 'orden'
                document.getElementById("orden").value = campo;
                // [ESTUDIO] y vuelve a pedir los datos con ese orden
                cargaTabla();
            });
        });

        // [ESTUDIO] (agregado en PHP 11) boton Cerrar sesion: va a destruirsesion.php, que borra la sesion y vuelve al login
        document.getElementById("btCierraSesion").addEventListener("click", function () {
            location.href = "../destruirsesion.php";
        });

        // [ESTUDIO] arranque: apenas carga la pagina pide las sucursales
        cargaSucursales();
    </script>

</body>

</html>
