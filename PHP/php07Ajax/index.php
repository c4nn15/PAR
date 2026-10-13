<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php07 - Ajax con fetch</title>

    <meta name="addsearch-category" content="PHP, Ajax, fetch, promesas, md5, sha1" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>Ajax con API fetch</h1>
    </header>

    <hr />

    <main class="tablero">

        <div id="zonaEntrada">
            <label for="clave">Clave a encriptar:</label>
            <input type="text" id="clave" value="Pepe" />
            <!-- Disparador del requerimiento asincronico -->
            <button type="button" id="disparo" title="Esperar 3 segundos de retardo para la respuesta">&#10148;</button>
        </div>

        <div id="estado">Estado del requerimiento: sin disparar</div>

        <div id="resultado">Resultado:</div>

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
        // Ajax se ejecuta del lado del CLIENTE (pag. 7 del apunte). Se usa
        // el API fetch(), sin jQuery.
        const divEstado = document.getElementById("estado");
        const divResultado = document.getElementById("resultado");

        function dispararAjax() {
            // URLSearchParams arma la cadena de datos variable=valor&...
            // que viajara en el body del requerimiento (pag. 8).
            const data = new URLSearchParams();
            data.append("clave", document.getElementById("clave").value);

            // Configuracion de la estructura del requerimiento HTTP
            const options = {
                method: "POST",
                headers: {
                    "Content-Type": "application/x-www-form-urlencoded"
                },
                body: data
            };

            alert("Como se usa el protocolo POST, los datos viajaran en el body del requerimiento HTTP: " + data.toString());

            // Promesa pendiente: se limpian las zonas de respuesta y se
            // muestra un estado provisorio de espera.
            divEstado.textContent = "Estado del requerimiento: esperando respuesta...";
            divResultado.textContent = "Esperando respuesta...";
            divResultado.classList.add("esperando");

            // fetch devuelve una promesa (pag. 9). then() se ejecuta cuando
            // llega la respuesta; catch() solo ante un error de red.
            fetch("./respuesta.php", options)
                .then(respuesta => {
                    return respuesta.text();
                })
                .then(textoDeRespuesta => {
                    // Evento de arribo de la respuesta HTTP: promesa cumplida
                    alert("Se recibió la data del servidor (método POST):\n" + textoDeRespuesta);
                    divEstado.textContent = "Estado del requerimiento: promesa cumplida";
                    divResultado.classList.remove("esperando");
                    divResultado.innerHTML = "Resultado:<br />" + textoDeRespuesta;
                })
                .catch(error => {
                    divEstado.textContent = "Estado del requerimiento: promesa rechazada";
                    divResultado.classList.remove("esperando");
                    divResultado.textContent = "Error producido: " + error;
                });
        }

        document.getElementById("disparo").addEventListener("click", dispararAjax);
    </script>

</body>

</html>
