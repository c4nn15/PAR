<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php08 - Form to JSON con fetch</title>

    <meta name="addsearch-category" content="PHP, Ajax, fetch, FormData, json_encode" />

    <!-- Sin hoja de estilos: solo importa el concepto. -->
</head>

<body>

    <h1>Form to JSON utilizando API fetch</h1>
    <p class="alumno" style="font-weight: bold;">Alumno: Santiago Cannistra</p>

    <hr />

    <form id="formulario" method="post" action="./respuesta.php">
        <label for="codUsuario">Código:</label>
        <input title="Ingrese: Código" type="text" id="codUsuario" name="codUsuario" value="1234" required />
        <br /><br />

        <label for="apellido">Apellido:</label>
        <input title="Ingrese: Apellido" type="text" id="apellido" name="apellido" value="Wicker" required />
        <br /><br />

        <label for="nombre">Nombre:</label>
        <input title="Ingrese: Nombre" type="text" id="nombre" name="nombre" value="Bus" required />
        <br /><br />

        <!-- Envio tradicional: la respuesta REEMPLAZA al documento -->
        <button title="Botón: Enviar formulario de manera tradicional" type="submit">Enviar formulario de manera tradicional</button>

        <!-- type="button": no envia el form, solo dispara el Ajax -->
        <button type="button" id="disparo" title="Esperar 3 segundos de retardo para la respuesta">
            Disparar requerimiento asincrónico Ajax
        </button>
    </form>

    <hr />

    <p><a href="../index.html">Volver al indice de PHP</a></p>

    <script>
        const objFormulario = document.getElementById("formulario");

        document.getElementById("disparo").addEventListener("click", function () {
            // FormData contiene todos los datos del formulario, listos para
            // enviar como un form HTML multipart/form-data (pag. 12).
            const objDatosFormulario = new FormData(objFormulario);
            console.log("valor del input codUsuario: " + objDatosFormulario.get("codUsuario"));

            // Con FormData NO se define Content-Type: el navegador lo arma
            // solo (incluido el boundary) (pag. 13).
            const options = {
                method: "post",
                headers: {},
                body: objDatosFormulario
            };

            fetch("./respuesta.php", options)
                .then(respuesta => {
                    return respuesta.text();
                })
                .then(textoDeRespuesta => {
                    alert("Llegó la respuesta HTTP:\n" + textoDeRespuesta);
                })
                .catch(error => alert("Error producido: " + error));
        });
    </script>

</body>

</html>
