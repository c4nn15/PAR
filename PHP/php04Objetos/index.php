<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php04 - Objetos, arreglos de objetos y JSON</title>

    <meta name="addsearch-category" content="PHP, stdClass, objetos, json_encode, arreglos" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>Variables de tipo objeto</h1>
    </header>

    <hr />

    <main>

        <section>
            <h2>1) Un objeto cliente</h2>

            <p>
                Se usa la tabla asignada en Especiales (<code>clientes.js</code>): cada cliente se
                arma como un objeto PHP instanciado desde la clase estandar <strong>stdClass</strong>,
                igual que en el apunte (pag. 9). Sus atributos se asignan con la flecha <strong>-&gt;</strong>.
            </p>

            <?php
                $objCliente = new stdClass();
                $objCliente->codCliente = "CLI001";
                $objCliente->direccionEntrega = "Av. Rivadavia 4520, CABA";
                $objCliente->diaSemanalEntrega = "Lunes";
                $objCliente->costoPromedioTransporte = 1850;
            ?>

            <p>$objCliente->codCliente = <?php echo $objCliente->codCliente; ?></p>
            <p>$objCliente->direccionEntrega = <?php echo $objCliente->direccionEntrega; ?></p>
            <p>$objCliente->diaSemanalEntrega = <?php echo $objCliente->diaSemanalEntrega; ?></p>
            <p>$objCliente->costoPromedioTransporte = <?php echo $objCliente->costoPromedioTransporte; ?></p>
            <p>gettype($objCliente) = <?php echo gettype($objCliente); ?></p>
        </section>

        <hr />

        <section>
            <h2>2) Arreglo de objetos cliente</h2>

            <?php
                // $clientes va a contener OBJETOS cliente, no arreglos
                // asociativos (pag. 10 del apunte).
                $clientes = [];
                array_push($clientes, $objCliente);

                $objCliente2 = new stdClass();
                $objCliente2->codCliente = "CLI002";
                $objCliente2->direccionEntrega = "Calle 50 N 1234, La Plata";
                $objCliente2->diaSemanalEntrega = "Martes";
                $objCliente2->costoPromedioTransporte = 2100;
                array_push($clientes, $objCliente2);
            ?>

            <p>gettype($clientes) = <?php echo gettype($clientes); ?></p>

            <table>
                <tr>
                    <th>codCliente</th>
                    <th>direccionEntrega</th>
                    <th>diaSemanalEntrega</th>
                    <th>costoPromedioTransporte</th>
                </tr>
                <?php
                    // Barrido del arreglo de objetos: cada renglon de la
                    // tabla se arma con los atributos del objeto actual.
                    foreach ($clientes as $unCliente) {
                        echo "<tr>";
                        echo "<td>" . $unCliente->codCliente . "</td>";
                        echo "<td>" . $unCliente->direccionEntrega . "</td>";
                        echo "<td>" . $unCliente->diaSemanalEntrega . "</td>";
                        echo "<td>" . $unCliente->costoPromedioTransporte . "</td>";
                        echo "</tr>";
                    }
                ?>
            </table>

            <p>count($clientes) = <?php echo count($clientes); ?></p>
        </section>

        <hr />

        <section>
            <h2>3) Un objeto "clientes" que envuelve al arreglo</h2>

            <p>
                En vez de entregar solo el arreglo, se arma un objeto nuevo con dos atributos: el
                arreglo completo de clientes y la cantidad de elementos que contiene (pag. 11 del
                apunte).
            </p>

            <?php
                $objClientes = new stdClass();
                $objClientes->clientes = $clientes;
                $objClientes->cantidadDeClientes = count($clientes);

                // json_encode traduce el objeto PHP a texto JSON, listo para
                // ser entregado al navegador remoto (pag. 12 del apunte).
                $jsonClientes = json_encode($objClientes);
            ?>

            <p>$objClientes->cantidadDeClientes = <?php echo $objClientes->cantidadDeClientes; ?></p>

            <p>JSON resultante ($jsonClientes):</p>
            <pre><?php echo $jsonClientes; ?></pre>
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
