<?php
    session_start();   // [ESTUDIO] inicia/retoma la sesion; debe ir antes de cualquier salida HTML
    include "./libreria.inc";   // [ESTUDIO] funciones autenticacion, incrementaContador, infoDeSesion

    // Solo autentica y crea sesion si no hay una (un reload no vuelve a incrementar el contador).
    if (!isset($_SESSION['identificativo'])) {   // [ESTUDIO] solo si todavia NO hay sesion iniciada
        $log = isset($_POST['login']) ? $_POST['login'] : '';   // [ESTUDIO] login enviado por el formulario
        $cl = isset($_POST['clave']) ? $_POST['clave'] : '';   // [ESTUDIO] clave enviada
        $usuario = null;   // [ESTUDIO] autenticacion lo completa por referencia si valida
        if (!autenticacion($log, $cl, $usuario)) {   // [ESTUDIO] credenciales incorrectas
            header('Location: ./formularioDeLogin.html');   // [ESTUDIO] vuelve al login
            exit();   // [ESTUDIO] corta: sin esto el script seguiria y crearia la sesion igual
        }
        $_SESSION['identificativo'] = session_create_id();   // [ESTUDIO] genera un id unico; funciona como marca de 'sesion valida' (la que chequea manejoSesion.inc)
        $_SESSION['login'] = $usuario['loginUsuario'];   // [ESTUDIO] guarda el login en la sesion
        $_SESSION['idUsuario'] = $usuario['idUsuario'];   // [ESTUDIO] guarda el id del usuario
        $_SESSION['ContadorDeSesion'] = incrementaContador($usuario['idUsuario'], $usuario['contador']);   // [ESTUDIO] suma 1 al contador de ingresos en la base y lo guarda en la sesion
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
    <header><h1>Ingresó a la aplicación</h1>
    <p class="alumno" style="font-weight: bold;">Alumno: Santiago Cannistra</p></header>
    <hr />
    <main>
        <h2>Sus parámetros de sesión son los siguientes:</h2>
        <?php infoDeSesion(); ?> <!-- [ESTUDIO] PHP imprime aqui la lista con los datos de la sesion -->
        <button title="Botón: Ingresar al ABM" type="button" id="btAppModulo1">Ingresar al ABM</button>
        <button title="Botón: Terminar sesión" type="button" id="btSalida">Terminar sesión</button>
    </main>
    <script>
        // [ESTUDIO] click en "Ingresar al ABM": navega a la aplicacion protegida
        document.getElementById("btAppModulo1").addEventListener("click", function () {
            location.href = "./app_modulo1/index.php";
        });
        // [ESTUDIO] click en "Terminar sesion": navega a destruirsesion.php
        document.getElementById("btSalida").addEventListener("click", function () {
            location.href = "./destruirsesion.php";
        });
    </script>
</body>
</html>
