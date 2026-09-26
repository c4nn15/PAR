<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php03 - Variables globales de servidor</title>

    <meta name="addsearch-category" content="PHP, $_SERVER, variables globales, HTTP" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>Variables globales de servidor</h1>
    </header>

    <hr />

    <main>

        <section>
            <p>
                <strong>$_SERVER</strong> es un arreglo global asociativo: el indice de cada
                elemento es una cadena que describe el dato (pag. 8 del apunte). Sus elementos se
                agrupan en tres tipos: variables propias del servidor, del cliente remoto que hace
                el pedido, y del requerimiento HTTP en curso.
            </p>

            <h2>Variables de servidor</h2>
            <table>
                <tr><th>Indice</th><th>Valor</th></tr>
                <tr><td>SERVER_ADDR</td><td><?php echo $_SERVER['SERVER_ADDR'] ?? ''; ?></td></tr>
                <tr><td>SERVER_NAME</td><td><?php echo $_SERVER['SERVER_NAME'] ?? ''; ?></td></tr>
                <tr><td>HTTP_HOST</td><td><?php echo $_SERVER['HTTP_HOST'] ?? ''; ?></td></tr>
                <tr><td>DOCUMENT_ROOT</td><td><?php echo $_SERVER['DOCUMENT_ROOT'] ?? ''; ?></td></tr>
            </table>

            <h2>Variables de cliente</h2>
            <table>
                <tr><th>Indice</th><th>Valor</th></tr>
                <tr><td>REMOTE_ADDR</td><td><?php echo $_SERVER['REMOTE_ADDR'] ?? ''; ?></td></tr>
                <tr><td>REMOTE_PORT</td><td><?php echo $_SERVER['REMOTE_PORT'] ?? ''; ?></td></tr>
            </table>

            <h2>Variables de requerimiento</h2>
            <table>
                <tr><th>Indice</th><th>Valor</th></tr>
                <tr><td>SCRIPT_NAME</td><td><?php echo $_SERVER['SCRIPT_NAME'] ?? ''; ?></td></tr>
                <tr><td>REQUEST_METHOD</td><td><?php echo $_SERVER['REQUEST_METHOD'] ?? ''; ?></td></tr>
                <tr><td>REQUEST_URI</td><td><?php echo $_SERVER['REQUEST_URI'] ?? ''; ?></td></tr>
                <tr><td>QUERY_STRING</td><td><?php echo $_SERVER['QUERY_STRING'] ?? ''; ?></td></tr>
            </table>

            <h2>El arreglo completo</h2>
            <p>
                Barriendo <strong>$_SERVER</strong> con <strong>foreach($_SERVER as $key =&gt; $value)</strong>
                se puede mostrar el resto de los elementos sin tener que nombrarlos uno por uno.
            </p>
            <table>
                <tr><th>Indice</th><th>Valor</th></tr>
                <?php
                    foreach ($_SERVER as $key_name => $key_value) {
                        // is_array() evita romper la tabla con elementos como
                        // argv, que llegan como arreglo en vez de texto.
                        if (!is_array($key_value)) {
                            echo "<tr><td>" . $key_name . "</td><td>" . $key_value . "</td></tr>";
                        }
                    }
                ?>
            </table>
        </section>

    </main>

    <hr />

    <footer>
        <p><a href="../index.html">Volver al indice de PHP</a></p>

        Santiago Cannistra
        <address>
            Programación en Ambiente de Redes
        </address>
    </footer>

</body>
</html>
