<?php
    include "../manejoSesion.inc";
    include "../conexion.php";

    sleep(1);

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';

    $respuesta_estado = "Codigo de cliente recibido para borrar: " . htmlspecialchars($codCliente) . "<br />\n";

    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";
        $sql = "delete from clientes where codCliente=:codCliente";
        ejecutarConEstado($dbh, $sql, [":codCliente" => $codCliente], $respuesta_estado);
    }

    $dbh = null;
    echo $respuesta_estado;
?>
