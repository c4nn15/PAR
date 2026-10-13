<?php
    // Lectura y envio de formulario en UN SOLO php (pag. 1 del apunte).
    // isset() devuelve true si en el requerimiento POST llego la variable
    // 'clave': es decir, si lo que llega es el formulario ya completado.
    if (isset($_POST['clave'])) {
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php06 - Form to encrypt (resultado)</title>
</head>

<body>

    <h1>Form to encrypt</h1>

    <hr />

    <?php
        $clave = $_POST['clave'];

        // Encriptacion unidireccional (pag. 2 del apunte): no admite
        // desencriptar. md5() devuelve 128 bits = 16 pares hexadecimales
        // (32 caracteres). sha1() devuelve 160 bits = 20 pares
        // hexadecimales (40 caracteres).
        $claveMd5 = md5($clave);
        $claveSha1 = sha1($clave);
    ?>

    <p>Clave ingresada: <?php echo htmlspecialchars($clave); ?></p>
    <p>MD5 (128 bits, 16 pares hexa): <?php echo $claveMd5; ?></p>
    <p>SHA1 (160 bits, 20 pares hexa): <?php echo $claveSha1; ?></p>

    <hr />

    <p><a href="./index.php">Volver</a></p>

</body>

</html>
<?php
    }
    else {
        // No llegaron datos: el server devuelve el codigo del formulario.
?>
<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php06 - Form to encrypt</title>

    <meta name="addsearch-category" content="PHP, md5, sha1, formularios" />

    <!-- A proposito, sin hoja de estilos: solo HTML. -->
</head>

<body>

    <h1>Form to encrypt</h1>

    <hr />

    <p>Envio de un formulario para ser encriptado del lado del servidor.</p>

    <!-- action vacio: el formulario se envia al mismo php que lo mostro -->
    <form action="./index.php" method="post">
        <label for="clave">Ingresar la clave a encriptar:</label>
        <input type="text" id="clave" name="clave" required />
        <br /><br />

        <button type="submit">Obtener encriptación</button>
    </form>

    <hr />

    <p><a href="../index.html">Volver al indice de PHP</a></p>

</body>

</html>
<?php
    }
?>
