<?php
    // Proteccion en sesion para los scripts de app_modulo1 (se incluye en la primera linea).
    session_start();
    if (!isset($_SESSION['identificativo'])) {
        header('Location: ../index.php');
        exit();
    }
?>
