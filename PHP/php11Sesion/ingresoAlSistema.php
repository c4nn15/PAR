<?php
    session_start();
    include "./libreria.inc";

    // Solo autentica y crea sesion si no hay una (un reload no vuelve a incrementar el contador).
    if (!isset($_SESSION['identificativo'])) {
        $log = isset($_POST['login']) ? $_POST['login'] : '';
        $cl = isset($_POST['clave']) ? $_POST['clave'] : '';
        $usuario = null;
        if (!autenticacion($log, $cl, $usuario)) {
            header('Location: ./formularioDeLogin.html');
            exit();
        }
        $_SESSION['identificativo'] = session_create_id();
        $_SESSION['login'] = $usuario['loginUsuario'];
        $_SESSION['idUsuario'] = $usuario['idUsuario'];
        $_SESSION['ContadorDeSesion'] = incrementaContador($usuario['idUsuario'], $usuario['contador']);
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ingreso al sistema</title>
    <link rel="stylesheet" href="./app_modulo1/estilo.css">
</head>
<body>
    <header><h1>Ingresó a la aplicación</h1></header>
    <hr />
    <main>
        <h2>Sus parámetros de sesión son los siguientes:</h2>
        <?php infoDeSesion(); ?>
        <button type="button" id="btAppModulo1">Ingresar al ABM</button>
        <button type="button" id="btSalida">Terminar sesión</button>
    </main>
    <script>
        document.getElementById("btAppModulo1").addEventListener("click", function () {
            location.href = "./app_modulo1/index.php";
        });
        document.getElementById("btSalida").addEventListener("click", function () {
            location.href = "./destruirsesion.php";
        });
    </script>
</body>
</html>
