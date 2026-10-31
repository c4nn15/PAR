<?php
    include "../manejoSesion.inc";
    include "../conexion.php";

    header("Content-Type: application/json; charset=utf-8");
    sleep(1);

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';

    $objSalida = new stdClass();
    $objSalida->estado = "";
    $objSalida->mime = "";
    $objSalida->documento = "";

    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {
            $stmt = $dbh->prepare("select fotoPuntoEntrega from clientes where codCliente = :codCliente");
            $stmt->bindParam(':codCliente', $codCliente);
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();
            $fila = $stmt->fetch();

            if ($fila === false || $fila['fotoPuntoEntrega'] === null) {
                $objSalida->estado = "El registro no tiene archivo asociado";
            } else {
                // El binario viaja en base64 para que no se confunda con HTML. El tipo
                // se detecta del contenido, asi sirve tanto para PDF como para imagenes.
                $finfo = new finfo(FILEINFO_MIME_TYPE);
                $objSalida->mime = $finfo->buffer($fila['fotoPuntoEntrega']);
                $objSalida->documento = base64_encode($fila['fotoPuntoEntrega']);
                $objSalida->estado = "ok";
            }
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (traeDoc): " . $e->getMessage());
            $objSalida->estado = "Error al ejecutar la sentencia";
        }
    }

    $dbh = null;
    echo json_encode($objSalida, JSON_INVALID_UTF8_SUBSTITUTE);
?>
