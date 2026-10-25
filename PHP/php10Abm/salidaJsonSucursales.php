<?php
    include "./conexion.php";

    header("Content-Type: application/json; charset=utf-8");
    sleep(2);

    $objSalida = new stdClass();
    $objSalida->sucursales = [];
    $objSalida->estado = "";

    $dbh = abrirConexion($host, $dbname, $user, $password);

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {
            $stmt = $dbh->prepare("select codSucursal, nombreSucursal from sucursales order by nombreSucursal");
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            $stmt->execute();

            while ($fila = $stmt->fetch()) {
                $objSucursal = new stdClass();
                $objSucursal->codSucursal = $fila['codSucursal'];
                $objSucursal->nombreSucursal = $fila['nombreSucursal'];
                array_push($objSalida->sucursales, $objSucursal);
            }
            $objSalida->estado = "ok";
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (sucursales): " . $e->getMessage());
            $objSalida->estado = "Error al ejecutar la sentencia";
        }
    }

    $dbh = null;
    echo json_encode($objSalida);
?>
