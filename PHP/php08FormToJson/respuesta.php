<?php
    // Retardo a proposito para simular la red (se nota el efecto Ajax)
    sleep(3);

    // Armado de un objeto con datos leidos de un formulario (pag. 11):
    // instanciacion de un objeto de datos y asignacion de propiedades con
    // los valores del arreglo global $_POST.
    $objUsuario = new stdClass();
    $objUsuario->codUsuario = $_POST['codUsuario'];
    $objUsuario->apellido = $_POST['apellido'];
    $objUsuario->nombre = $_POST['nombre'];

    // La respuesta es JSON puro, sin una gota de HTML
    header('Content-Type: application/json; charset=utf-8');

    $jsonUsuario = json_encode($objUsuario);
    echo $jsonUsuario;
?>
