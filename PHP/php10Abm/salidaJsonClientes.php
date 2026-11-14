<?php
    include "./conexion.php";    // [ESTUDIO] datos de conexion y funciones auxiliares

    header("Content-Type: application/json; charset=utf-8");   // [ESTUDIO] la respuesta sera JSON

    // Retardo a proposito para ver el estado "Esperando respuesta".
    sleep(2);

    // 1) Recepcion de variables del requerimiento
    // [ESTUDIO] Cada filtro y el orden llegan por POST; si faltan, valor por defecto ('' o 'codCliente')
    $orden = isset($_POST['orden']) ? $_POST['orden'] : 'codCliente';
    $f_clientes_codCliente = isset($_POST['f_clientes_codCliente']) ? $_POST['f_clientes_codCliente'] : '';
    $f_clientes_codSucursal = isset($_POST['f_clientes_codSucursal']) ? $_POST['f_clientes_codSucursal'] : '';
    $f_clientes_direccionEntrega = isset($_POST['f_clientes_direccionEntrega']) ? $_POST['f_clientes_direccionEntrega'] : '';
    $f_clientes_diaSemanalEntrega = isset($_POST['f_clientes_diaSemanalEntrega']) ? $_POST['f_clientes_diaSemanalEntrega'] : '';
    $f_clientes_costoPromedioTransporte = isset($_POST['f_clientes_costoPromedioTransporte']) ? $_POST['f_clientes_costoPromedioTransporte'] : '';
    $f_clientes_fechaUltimaEntrega = isset($_POST['f_clientes_fechaUltimaEntrega']) ? $_POST['f_clientes_fechaUltimaEntrega'] : '';

    // El ORDER BY no admite parametros vinculados: se valida contra lista blanca
    // para que nadie pueda inyectar SQL por la variable "orden".
    $ordenesValidos = ['codCliente', 'codSucursal', 'direccionEntrega', 'diaSemanalEntrega', 'costoPromedioTransporte', 'fechaUltimaEntrega'];   // [ESTUDIO] unicos nombres de columna aceptados
    if (!in_array($orden, $ordenesValidos)) {   // [ESTUDIO] si el valor recibido no esta en la lista...
        $orden = 'codCliente';                  // [ESTUDIO] ...se usa el orden por defecto
    }

    $objSalida = new stdClass();   // [ESTUDIO] objeto que se convertira en el JSON de respuesta
    $objSalida->clientes = [];     // [ESTUDIO] arreglo de clientes encontrados
    $objSalida->cuenta = 0;        // [ESTUDIO] cantidad de registros
    $objSalida->estado = "";       // [ESTUDIO] "ok" o mensaje de error

    // 2) Apertura de conexion
    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {
            // 3) Consulta SQL. La foto (longblob) no se trae: json_encode no
            // admite binario, solo se informa si el registro tiene foto.
            // [ESTUDIO] LIKE CONCAT('%',:x,'%') = "contiene el texto"; con '' coincide con todo. (fotoPuntoEntrega is not null) da 1/0 como tieneFoto
            $sql = "select codCliente, codSucursal, direccionEntrega, diaSemanalEntrega, ";
            $sql = $sql . "costoPromedioTransporte, fechaUltimaEntrega, (fotoPuntoEntrega is not null) as tieneFoto ";
            $sql = $sql . "from clientes where ";
            $sql = $sql . "codCliente LIKE CONCAT('%',:codCliente,'%') and ";
            $sql = $sql . "codSucursal LIKE CONCAT('%',:codSucursal,'%') and ";
            $sql = $sql . "direccionEntrega LIKE CONCAT('%',:direccionEntrega,'%') and ";
            $sql = $sql . "diaSemanalEntrega LIKE CONCAT('%',:diaSemanalEntrega,'%') and ";
            $sql = $sql . "costoPromedioTransporte LIKE CONCAT('%',:costoPromedioTransporte,'%') and ";
            $sql = $sql . "fechaUltimaEntrega LIKE CONCAT('%',:fechaUltimaEntrega,'%')";
            $sql = $sql . " ORDER BY $orden";   // [ESTUDIO] se concatena directo (no admite parametros) pero ya fue validado con la lista blanca

            // 4) Preparacion, vinculacion y ejecucion
            $stmt = $dbh->prepare($sql);                                              // [ESTUDIO] prepara la consulta
            $stmt->bindParam(':codCliente', $f_clientes_codCliente);                  // [ESTUDIO] bindParam vincula cada variable a su marcador
            $stmt->bindParam(':codSucursal', $f_clientes_codSucursal);
            $stmt->bindParam(':direccionEntrega', $f_clientes_direccionEntrega);
            $stmt->bindParam(':diaSemanalEntrega', $f_clientes_diaSemanalEntrega);
            $stmt->bindParam(':costoPromedioTransporte', $f_clientes_costoPromedioTransporte);
            $stmt->bindParam(':fechaUltimaEntrega', $f_clientes_fechaUltimaEntrega);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);                                    // [ESTUDIO] filas como arreglo asociativo
            $stmt->execute();                                                         // [ESTUDIO] corre la consulta

            // 5) Construccion de la respuesta
            while ($fila = $stmt->fetch()) {                                          // [ESTUDIO] mientras haya filas (fetch devuelve false al terminar)
                $objCliente = new stdClass();                                         // [ESTUDIO] un objeto por cliente
                $objCliente->codCliente = $fila['codCliente'];
                $objCliente->codSucursal = $fila['codSucursal'];
                $objCliente->direccionEntrega = $fila['direccionEntrega'];
                $objCliente->diaSemanalEntrega = $fila['diaSemanalEntrega'];
                $objCliente->costoPromedioTransporte = $fila['costoPromedioTransporte'];
                $objCliente->fechaUltimaEntrega = $fila['fechaUltimaEntrega'];
                $objCliente->tieneFoto = (bool)$fila['tieneFoto'];                    // [ESTUDIO] casteo 1/0 -> true/false
                array_push($objSalida->clientes, $objCliente);                        // [ESTUDIO] agrega el cliente al final del arreglo
            }
            $objSalida->cuenta = count($objSalida->clientes);                         // [ESTUDIO] cantidad de clientes devueltos
            $objSalida->estado = "ok";
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (clientes): " . $e->getMessage());   // [ESTUDIO] error tecnico al log
            $objSalida->estado = "Error al ejecutar la sentencia";                           // [ESTUDIO] mensaje generico al cliente
        }
    }

    // 6) y 7) JSON y envio
    $dbh = null;                    // [ESTUDIO] cierra la conexion
    echo json_encode($objSalida);   // [ESTUDIO] convierte el objeto a texto JSON y lo envia
?>
