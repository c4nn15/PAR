<?php
    include "./conexion.php";

    sleep(1);

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';
    $codSucursal = isset($_POST['codSucursal']) ? $_POST['codSucursal'] : '';
    $direccionEntrega = isset($_POST['direccionEntrega']) ? $_POST['direccionEntrega'] : '';
    $diaSemanalEntrega = isset($_POST['diaSemanalEntrega']) ? $_POST['diaSemanalEntrega'] : '';
    $costoPromedioTransporte = isset($_POST['costoPromedioTransporte']) ? $_POST['costoPromedioTransporte'] : '';
    $fechaUltimaEntrega = isset($_POST['fechaUltimaEntrega']) ? $_POST['fechaUltimaEntrega'] : '';

    $respuesta_estado = "Respuesta del servidor al alta. Entradas recibidas en el req http:<br />\n";
    $respuesta_estado = $respuesta_estado . "codCliente: " . htmlspecialchars($codCliente) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "codSucursal: " . htmlspecialchars($codSucursal) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "direccionEntrega: " . htmlspecialchars($direccionEntrega) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "diaSemanalEntrega: " . htmlspecialchars($diaSemanalEntrega) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "costoPromedioTransporte: " . htmlspecialchars($costoPromedioTransporte) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "fechaUltimaEntrega: " . htmlspecialchars($fechaUltimaEntrega) . "<br /><br />\n";
    $respuesta_estado = $respuesta_estado . "Parte alta simple de datos<br />\n";

    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";

        // Los atributos binarios no van en el insert: se actualizan despues.
        $sql = "insert into clientes (codCliente,codSucursal,direccionEntrega,diaSemanalEntrega,costoPromedioTransporte,fechaUltimaEntrega) ";
        $sql = $sql . "values (:codCliente,:codSucursal,:direccionEntrega,:diaSemanalEntrega,:costoPromedioTransporte,:fechaUltimaEntrega)";

        $ok = ejecutarConEstado($dbh, $sql, [
            ":codCliente" => $codCliente,
            ":codSucursal" => $codSucursal,
            ":direccionEntrega" => $direccionEntrega,
            ":diaSemanalEntrega" => $diaSemanalEntrega,
            ":costoPromedioTransporte" => $costoPromedioTransporte,
            ":fechaUltimaEntrega" => $fechaUltimaEntrega,
        ], $respuesta_estado);

        if ($ok) {
            actualizaBinario($dbh, $codCliente, $respuesta_estado);
        }
    }

    $dbh = null;
    echo $respuesta_estado;
?>
