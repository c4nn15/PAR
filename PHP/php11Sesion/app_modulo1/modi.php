<?php
    include "../manejoSesion.inc";
    include "../conexion.php";

    sleep(1);

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';
    $codSucursal = isset($_POST['codSucursal']) ? $_POST['codSucursal'] : '';
    $direccionEntrega = isset($_POST['direccionEntrega']) ? $_POST['direccionEntrega'] : '';
    $diaSemanalEntrega = isset($_POST['diaSemanalEntrega']) ? $_POST['diaSemanalEntrega'] : '';
    $costoPromedioTransporte = isset($_POST['costoPromedioTransporte']) ? $_POST['costoPromedioTransporte'] : '';
    $fechaUltimaEntrega = isset($_POST['fechaUltimaEntrega']) ? $_POST['fechaUltimaEntrega'] : '';

    $respuesta_estado = "Parte modificacion simple de datos<br />\n";
    $respuesta_estado = $respuesta_estado . "codCliente: " . htmlspecialchars($codCliente) . "<br />\n";

    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";

        // La clave (codCliente) solo se usa en el WHERE; el binario se actualiza aparte.
        $sql = "update clientes set codSucursal=:codSucursal,direccionEntrega=:direccionEntrega,";
        $sql = $sql . "diaSemanalEntrega=:diaSemanalEntrega,costoPromedioTransporte=:costoPromedioTransporte,";
        $sql = $sql . "fechaUltimaEntrega=:fechaUltimaEntrega where codCliente=:codCliente";

        $ok = ejecutarConEstado($dbh, $sql, [
            ":codSucursal" => $codSucursal,
            ":direccionEntrega" => $direccionEntrega,
            ":diaSemanalEntrega" => $diaSemanalEntrega,
            ":costoPromedioTransporte" => $costoPromedioTransporte,
            ":fechaUltimaEntrega" => $fechaUltimaEntrega,
            ":codCliente" => $codCliente,
        ], $respuesta_estado);

        if ($ok) {
            actualizaBinario($dbh, $codCliente, $respuesta_estado);
        }
    }

    $dbh = null;
    echo $respuesta_estado;
?>
