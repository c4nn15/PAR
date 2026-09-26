<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php05 - Lectura de formularios con GET y POST</title>

    <meta name="addsearch-category" content="PHP, formularios, $_GET, $_POST" />

    <!-- A proposito, este ejercicio va SIN hoja de estilos: lo unico que
         importa es el recorrido de los datos del formulario al servidor
         y de vuelta, sin distraerse con el diseño. -->
</head>

<body>

    <h1>Lectura de formularios</h1>

    <hr />

    <p>
        El formulario se envia por POST al script <code>respuesta.php</code>, que lee
        <strong>$_POST['nombre']</strong> y <strong>$_POST['apellido']</strong> (pag. 13 del
        apunte) y devuelve esos mismos valores en la respuesta HTTP.
    </p>

    <!-- action = el recurso que recibe los datos. method="post" hace que
         los valores viajen en el BODY del requerimiento, no en la URL. -->
    <form action="./respuesta.php" method="post">
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required />
        <br /><br />

        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required />
        <br /><br />

        <button type="submit">Ingresar</button>
    </form>

    <hr />

    <p><a href="../index.html">Volver al indice de PHP</a></p>

</body>
</html>
