<?php
    session_start();
    if (isset($_SESSION['identificativo'])) {
        $_SESSION = [];
        session_destroy();
    }
    header('Location: ./formularioDeLogin.html');
    exit();
?>
