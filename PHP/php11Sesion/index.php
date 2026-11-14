<?php
    session_start();   // [ESTUDIO] retoma la sesion existente
    if (!isset($_SESSION['identificativo'])) {   // [ESTUDIO] sin sesion iniciada...
        header('Location: ./formularioDeLogin.html');   // [ESTUDIO] ...redirige al login
        exit();   // [ESTUDIO] y corta el script
    }
    include "./libreria.inc";   // [ESTUDIO] trae infoDeSesion()
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sesión iniciada</title>
    <link rel="stylesheet" href="./app_modulo1/estilo.css">
</head>
<body>
    <header><h1>Sesión establecida</h1>
    <p class="alumno" style="font-weight: bold;">Alumno: Santiago Cannistra</p></header>
    <hr />
    <main>
        <h2>Sus parámetros de sesión son los siguientes:</h2>
        <?php infoDeSesion(); ?> <!-- [ESTUDIO] imprime los datos de la sesion actual -->
        <button title="Botón: Ingresar al ABM" type="button" id="btAppModulo1">Ingresar al ABM</button>
        <button title="Botón: Terminar sesión" type="button" id="btSalida">Terminar sesión</button>
    </main>
    <script>
        // [ESTUDIO] "Ingresar al ABM" -> app_modulo1/index.php (protegido por manejoSesion.inc)
        document.getElementById("btAppModulo1").addEventListener("click", function () {
            location.href = "./app_modulo1/index.php";
        });
        // [ESTUDIO] "Terminar sesion" -> destruirsesion.php
        document.getElementById("btSalida").addEventListener("click", function () {
            location.href = "./destruirsesion.php";
        });
    </script>
</body>
</html>
