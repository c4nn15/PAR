<?php
    // El php NO cambia por ser un requerimiento Ajax (pag. 10 del apunte):
    // elabora y envia la respuesta sin importar si el requerimiento es o no
    // asincronico.

    // Retardo a proposito para simular una respuesta compleja y poder ver
    // el estado de espera en el navegador.
    sleep(3);

    $clave = $_POST['clave'];

    echo "MD5: " . md5($clave) . "<br />SHA1: " . sha1($clave);
?>
