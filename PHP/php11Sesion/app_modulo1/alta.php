<?php
    include "../manejoSesion.inc";   // [ESTUDIO] GUARDIA DE SESION: session_start + si no hay $_SESSION["identificativo"] redirige al login y hace exit
    include "../conexion.php";    // [ESTUDIO] datos de conexion y funciones auxiliares (esta una carpeta mas arriba)

    sleep(1);                    // [ESTUDIO] demora 1 segundo a proposito para ver el "Esperando respuesta" en pantalla

    // [ESTUDIO] Operador ternario: si el campo llego por POST usa su valor, si no usa cadena vacia (evita warnings por indice inexistente)
    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';
    $codSucursal = isset($_POST['codSucursal']) ? $_POST['codSucursal'] : '';
    $direccionEntrega = isset($_POST['direccionEntrega']) ? $_POST['direccionEntrega'] : '';
    $diaSemanalEntrega = isset($_POST['diaSemanalEntrega']) ? $_POST['diaSemanalEntrega'] : '';
    $costoPromedioTransporte = isset($_POST['costoPromedioTransporte']) ? $_POST['costoPromedioTransporte'] : '';
    $fechaUltimaEntrega = isset($_POST['fechaUltimaEntrega']) ? $_POST['fechaUltimaEntrega'] : '';

    // [ESTUDIO] Se arma el texto de respuesta (HTML) concatenando con "."; htmlspecialchars escapa lo que ingreso el usuario
    $respuesta_estado = "Respuesta del servidor al alta. Entradas recibidas en el req http:<br />\n";
    $respuesta_estado = $respuesta_estado . "codCliente: " . htmlspecialchars($codCliente) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "codSucursal: " . htmlspecialchars($codSucursal) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "direccionEntrega: " . htmlspecialchars($direccionEntrega) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "diaSemanalEntrega: " . htmlspecialchars($diaSemanalEntrega) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "costoPromedioTransporte: " . htmlspecialchars($costoPromedioTransporte) . "<br />\n";
    $respuesta_estado = $respuesta_estado . "fechaUltimaEntrega: " . htmlspecialchars($fechaUltimaEntrega) . "<br /><br />\n";
    $respuesta_estado = $respuesta_estado . "Parte alta simple de datos<br />\n";

    $dbh = abrirConexion($host, $dbname, $user, $password);   // [ESTUDIO] abre la conexion PDO (devuelve null si falla)

    if ($dbh === null) {                                      // [ESTUDIO] === compara valor y tipo
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";

        // Los atributos binarios no van en el insert: se actualizan despues.
        // [ESTUDIO] INSERT con marcadores nombrados (:xxx): los valores NO se pegan al SQL, se vinculan aparte (previene inyeccion SQL)
        $sql = "insert into clientes (codCliente,codSucursal,direccionEntrega,diaSemanalEntrega,costoPromedioTransporte,fechaUltimaEntrega) ";
        $sql = $sql . "values (:codCliente,:codSucursal,:direccionEntrega,:diaSemanalEntrega,:costoPromedioTransporte,:fechaUltimaEntrega)";

        // [ESTUDIO] Ejecuta prepare + bind + execute; el arreglo asocia cada marcador con su variable
        $ok = ejecutarConEstado($dbh, $sql, [
            ":codCliente" => $codCliente,
            ":codSucursal" => $codSucursal,
            ":direccionEntrega" => $direccionEntrega,
            ":diaSemanalEntrega" => $diaSemanalEntrega,
            ":costoPromedioTransporte" => $costoPromedioTransporte,
            ":fechaUltimaEntrega" => $fechaUltimaEntrega,
        ], $respuesta_estado);                                // [ESTUDIO] $respuesta_estado se pasa por referencia y se va completando

        if ($ok) {                                            // [ESTUDIO] solo si el insert salio bien, sube el archivo binario
            actualizaBinario($dbh, $codCliente, $respuesta_estado);
        }
    }

    $dbh = null;                  // [ESTUDIO] cerrar la conexion PDO = asignar null al objeto
    echo $respuesta_estado;       // [ESTUDIO] envia el texto HTML al navegador (lo recibe el fetch del index.php)
?>
