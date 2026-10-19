<?php
    include "./conexion.php";

    header("Content-Type: application/json; charset=utf-8");

    // Retardo a proposito para ver el estado "Esperando respuesta".
    sleep(2);

    // 1) Recepcion de variables del requerimiento
    $orden = isset($_POST['orden']) ? $_POST['orden'] : 'codCliente';
    $f_clientes_codCliente = isset($_POST['f_clientes_codCliente']) ? $_POST['f_clientes_codCliente'] : '';
    $f_clientes_codSucursal = isset($_POST['f_clientes_codSucursal']) ? $_POST['f_clientes_codSucursal'] : '';
    $f_clientes_direccionEntrega = isset($_POST['f_clientes_direccionEntrega']) ? $_POST['f_clientes_direccionEntrega'] : '';
    $f_clientes_diaSemanalEntrega = isset($_POST['f_clientes_diaSemanalEntrega']) ? $_POST['f_clientes_diaSemanalEntrega'] : '';
    $f_clientes_costoPromedioTransporte = isset($_POST['f_clientes_costoPromedioTransporte']) ? $_POST['f_clientes_costoPromedioTransporte'] : '';
    $f_clientes_fechaUltimaEntrega = isset($_POST['f_clientes_fechaUltimaEntrega']) ? $_POST['f_clientes_fechaUltimaEntrega'] : '';

    // El ORDER BY no admite parametros vinculados: se valida contra lista blanca
    // para que nadie pueda inyectar SQL por la variable "orden".
    $ordenesValidos = ['codCliente', 'codSucursal', 'direccionEntrega', 'diaSemanalEntrega', 'costoPromedioTransporte', 'fechaUltimaEntrega'];
    if (!in_array($orden, $ordenesValidos)) {
        $orden = 'codCliente';
    }

    $objSalida = new stdClass();
    $objSalida->clientes = [];
    $objSalida->cuenta = 0;
    $objSalida->estado = "";

    // 2) Apertura de conexion
    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {
            // 3) Consulta SQL. La foto (longblob) no se trae: json_encode no
            // admite binario, solo se informa si el registro tiene foto.
            $sql = "select codCliente, codSucursal, direccionEntrega, diaSemanalEntrega, ";
            $sql = $sql . "costoPromedioTransporte, fechaUltimaEntrega, (fotoPuntoEntrega is not null) as tieneFoto ";
            $sql = $sql . "from clientes where ";
            $sql = $sql . "codCliente LIKE CONCAT('%',:codCliente,'%') and ";
            $sql = $sql . "codSucursal LIKE CONCAT('%',:codSucursal,'%') and ";
            $sql = $sql . "direccionEntrega LIKE CONCAT('%',:direccionEntrega,'%') and ";
            $sql = $sql . "diaSemanalEntrega LIKE CONCAT('%',:diaSemanalEntrega,'%') and ";
            $sql = $sql . "costoPromedioTransporte LIKE CONCAT('%',:costoPromedioTransporte,'%') and ";
            $sql = $sql . "fechaUltimaEntrega LIKE CONCAT('%',:fechaUltimaEntrega,'%')";
            $sql = $sql . " ORDER BY $orden";

            // 4) Preparacion, vinculacion y ejecucion
            $stmt = $dbh->prepare($sql);
            $stmt->bindParam(':codCliente', $f_clientes_codCliente);
            $stmt->bindParam(':codSucursal', $f_clientes_codSucursal);
            $stmt->bindParam(':direccionEntrega', $f_clientes_direccionEntrega);
            $stmt->bindParam(':diaSemanalEntrega', $f_clientes_diaSemanalEntrega);
            $stmt->bindParam(':costoPromedioTransporte', $f_clientes_costoPromedioTransporte);
            $stmt->bindParam(':fechaUltimaEntrega', $f_clientes_fechaUltimaEntrega);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();

            // 5) Construccion de la respuesta
            while ($fila = $stmt->fetch()) {
                $objCliente = new stdClass();
                $objCliente->codCliente = $fila['codCliente'];
                $objCliente->codSucursal = $fila['codSucursal'];
                $objCliente->direccionEntrega = $fila['direccionEntrega'];
                $objCliente->diaSemanalEntrega = $fila['diaSemanalEntrega'];
                $objCliente->costoPromedioTransporte = $fila['costoPromedioTransporte'];
                $objCliente->fechaUltimaEntrega = $fila['fechaUltimaEntrega'];
                $objCliente->tieneFoto = (bool)$fila['tieneFoto'];
                array_push($objSalida->clientes, $objCliente);
            }
            $objSalida->cuenta = count($objSalida->clientes);
            $objSalida->estado = "ok";
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (clientes): " . $e->getMessage());
            $objSalida->estado = "Error al ejecutar la sentencia";
        }
    }

    // 6) y 7) JSON y envio
    $dbh = null;
    echo json_encode($objSalida);
?>
