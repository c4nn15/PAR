<?php
    include "./conexion.php";    // [ESTUDIO] trae datos de conexion y funciones auxiliares

    sleep(1);                    // [ESTUDIO] demora de 1 segundo para ver el estado "Esperando respuesta"

    // [ESTUDIO] Lee cada campo de $_POST; si no llego usa '' (operador ternario con isset)
    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';
    $codSucursal = isset($_POST['codSucursal']) ? $_POST['codSucursal'] : '';
    $direccionEntrega = isset($_POST['direccionEntrega']) ? $_POST['direccionEntrega'] : '';
    $diaSemanalEntrega = isset($_POST['diaSemanalEntrega']) ? $_POST['diaSemanalEntrega'] : '';
    $costoPromedioTransporte = isset($_POST['costoPromedioTransporte']) ? $_POST['costoPromedioTransporte'] : '';
    $fechaUltimaEntrega = isset($_POST['fechaUltimaEntrega']) ? $_POST['fechaUltimaEntrega'] : '';

    $respuesta_estado = "Parte modificacion simple de datos<br />\n";                                   // [ESTUDIO] texto de respuesta que se va acumulando
    $respuesta_estado = $respuesta_estado . "codCliente: " . htmlspecialchars($codCliente) . "<br />\n"; // [ESTUDIO] htmlspecialchars escapa el dato del usuario

    $dbh = abrirConexion($host, $dbname, $user, $password);   // [ESTUDIO] abre la conexion PDO

    if ($dbh === null) {                                      // [ESTUDIO] la conexion fallo
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";

        // La clave (codCliente) solo se usa en el WHERE; el binario se actualiza aparte.
        // [ESTUDIO] UPDATE con marcadores nombrados; el WHERE limita el cambio al cliente indicado
        $sql = "update clientes set codSucursal=:codSucursal,direccionEntrega=:direccionEntrega,";
        $sql = $sql . "diaSemanalEntrega=:diaSemanalEntrega,costoPromedioTransporte=:costoPromedioTransporte,";
        $sql = $sql . "fechaUltimaEntrega=:fechaUltimaEntrega where codCliente=:codCliente";

        // [ESTUDIO] prepare + bind + execute en una sola llamada; devuelve true/false
        $ok = ejecutarConEstado($dbh, $sql, [
            ":codSucursal" => $codSucursal,
            ":direccionEntrega" => $direccionEntrega,
            ":diaSemanalEntrega" => $diaSemanalEntrega,
            ":costoPromedioTransporte" => $costoPromedioTransporte,
            ":fechaUltimaEntrega" => $fechaUltimaEntrega,
            ":codCliente" => $codCliente,
        ], $respuesta_estado);

        if ($ok) {                                            // [ESTUDIO] si el update funciono, procesa el archivo subido (si hay)
            actualizaBinario($dbh, $codCliente, $respuesta_estado);
        }
    }

    $dbh = null;                  // [ESTUDIO] cierra la conexion
    echo $respuesta_estado;       // [ESTUDIO] devuelve el HTML de estado al fetch del index.php
?>
