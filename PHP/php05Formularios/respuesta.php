<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php05 - Respuesta del formulario</title>
</head>

<body>

    <h1>Respuesta</h1>

    <hr />

    <?php
        // $_POST[] es el arreglo global asociativo con los datos recibidos
        // en un requerimiento HTTP enviado con method="post" (pag. 13 del
        // apunte). El indice de cada elemento es el atributo name="..."
        // del input correspondiente en el formulario.
        echo "<p>Valores pasados: " . $_POST['nombre'] . ", " . $_POST['apellido'] . "</p>";
    ?>

    <hr />

    <p><a href="./index.php">Volver</a></p>

</body>
</html>
