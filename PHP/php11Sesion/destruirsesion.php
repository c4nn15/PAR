<?php
    session_start();                                      // [ESTUDIO] hay que retomar la sesion para poder destruirla
    if (isset($_SESSION['identificativo'])) {             // [ESTUDIO] solo si hay una sesion iniciada
        $_SESSION = [];                                   // [ESTUDIO] vacia todas las variables de sesion
        session_destroy();                                // [ESTUDIO] elimina la sesion en el servidor
    }
    header('Location: ./formularioDeLogin.html');         // [ESTUDIO] vuelve al formulario de login
    exit();                                               // [ESTUDIO] termina el script
?>
