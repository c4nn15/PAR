<?php
    /*
        asignaciones.php

        Este archivo NO tiene HTML: solo declara y carga variables.
        Se incorpora al script principal con include(), como dice el
        apunte de PHP (pag. 7): "util para declarar y agregar datos".

        Si index.php intentara mostrar $persona1 o $persona2 ANTES de
        hacer el include de este archivo, PHP mostraria un warning de
        "variable indefinida" pero seguiria ejecutando el resto del
        programa igual (a diferencia de require(), que corta todo con
        un error fatal si el archivo no existe).
    */

    $persona1 = [
        "nombre" => "Guillermo",
        "apellido" => "Fernandez",
        "fechaNacimiento" => "12/05/1990",
    ];

    $persona2 = [
        "nombre" => "Ana",
        "apellido" => "Lopez",
        "fechaNacimiento" => "03/11/1985",
    ];
?>
