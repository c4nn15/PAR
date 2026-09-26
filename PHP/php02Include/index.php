<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php02 - Include: reutilizar codigo PHP</title>

    <meta name="addsearch-category" content="PHP, include, require, arreglos asociativos" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>Include()</h1>
    </header>

    <hr />

    <main>

        <section>
            <p>
                En este ejemplo se utiliza la funcion <strong>include()</strong>, que incorpora
                codigo PHP definido en otro archivo, en este caso <code>asignaciones.php</code>
                (pag. 7 del apunte). Si ese archivo no existiera, PHP mostraria un warning y
                seguiria ejecutando el resto del script igual; con <strong>require()</strong> en
                cambio la ejecucion se corta con un error fatal.
            </p>

            <?php
                // A partir de esta linea existen $persona1 y $persona2: vienen
                // definidas dentro de asignaciones.php.
                include("./asignaciones.php");
            ?>

            <table>
                <tr>
                    <th>Persona</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Fecha de nacimiento</th>
                </tr>
                <tr>
                    <td>persona1</td>
                    <td><?php echo $persona1['nombre']; ?></td>
                    <td><?php echo $persona1['apellido']; ?></td>
                    <td><?php echo $persona1['fechaNacimiento']; ?></td>
                </tr>
                <tr>
                    <td>persona2</td>
                    <td><?php echo $persona2['nombre']; ?></td>
                    <td><?php echo $persona2['apellido']; ?></td>
                    <td><?php echo $persona2['fechaNacimiento']; ?></td>
                </tr>
            </table>

            <p>count($persona1) = <?php echo count($persona1); ?></p>
            <p>count($persona2) = <?php echo count($persona2); ?></p>
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
