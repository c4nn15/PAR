<?php
    // Proteccion en sesion para los scripts de app_modulo1 (se incluye en la primera linea).
    session_start();                                      // [ESTUDIO] retoma la sesion del visitante (usa la cookie PHPSESSID) o crea una nueva; habilita $_SESSION
    if (!isset($_SESSION['identificativo'])) {            // [ESTUDIO] si NO existe la marca que se guarda al loguearse, no hay sesion valida
        header('Location: ../index.php');                 // [ESTUDIO] redirige al visitante (../index.php a su vez lo manda al login)
        exit();                                           // [ESTUDIO] corta la ejecucion: sin exit el resto del script seguiria corriendo aunque redirija
    }
?>
