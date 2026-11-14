<?php
    include "../manejoSesion.inc";   // [ESTUDIO] GUARDIA DE SESION: session_start + si no hay $_SESSION["identificativo"] redirige al login y hace exit
    include "../conexion.php";    // [ESTUDIO] datos de conexion y funciones auxiliares (esta una carpeta mas arriba)

    header("Content-Type: application/json; charset=utf-8");   // [ESTUDIO] la respuesta es JSON
    sleep(2);                                                  // [ESTUDIO] demora a proposito

    $objSalida = new stdClass();   // [ESTUDIO] objeto de respuesta
    $objSalida->sucursales = [];   // [ESTUDIO] lista de sucursales (alimenta el <select> del index)
    $objSalida->estado = "";

    $dbh = abrirConexion($host, $dbname, $user, $password);   // [ESTUDIO] abre la conexion

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {
            $stmt = $dbh->prepare("select codSucursal, nombreSucursal from sucursales order by nombreSucursal");   // [ESTUDIO] sin parametros: no hay marcadores que vincular
            $stmt->setFetchMode(PDO::FETCH_ASSOC);   // [ESTUDIO] filas como arreglo asociativo
            $stmt->execute();                        // [ESTUDIO] ejecuta

            while ($fila = $stmt->fetch()) {         // [ESTUDIO] recorre cada sucursal
                $objSucursal = new stdClass();
                $objSucursal->codSucursal = $fila['codSucursal'];
                $objSucursal->nombreSucursal = $fila['nombreSucursal'];
                array_push($objSalida->sucursales, $objSucursal);   // [ESTUDIO] agrega al arreglo de salida
            }
            $objSalida->estado = "ok";
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (sucursales): " . $e->getMessage());
            $objSalida->estado = "Error al ejecutar la sentencia";
        }
    }

    $dbh = null;                    // [ESTUDIO] cierra la conexion
    echo json_encode($objSalida);   // [ESTUDIO] devuelve el JSON
?>
