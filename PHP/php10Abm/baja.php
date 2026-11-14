<?php
    include "./conexion.php";    // [ESTUDIO] datos de conexion y funciones auxiliares

    sleep(1);                    // [ESTUDIO] demora de 1 segundo para ver el estado de espera

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';   // [ESTUDIO] unico dato necesario: la clave del cliente a borrar

    $respuesta_estado = "Codigo de cliente recibido para borrar: " . htmlspecialchars($codCliente) . "<br />\n";   // [ESTUDIO] inicia el texto de respuesta

    $dbh = abrirConexion($host, $dbname, $user, $password);   // [ESTUDIO] abre la conexion PDO

    if ($dbh === null) {                                      // [ESTUDIO] si no hubo conexion
        $respuesta_estado = $respuesta_estado . "Error en la conexion<br />\n";
    } else {
        $respuesta_estado = $respuesta_estado . "Conexion exitosa!<br />\n";
        $sql = "delete from clientes where codCliente=:codCliente";                          // [ESTUDIO] DELETE con WHERE (sin WHERE borraria toda la tabla)
        ejecutarConEstado($dbh, $sql, [":codCliente" => $codCliente], $respuesta_estado);    // [ESTUDIO] prepara, vincula y ejecuta; agrega el resultado al estado
    }

    $dbh = null;                  // [ESTUDIO] cierra la conexion
    echo $respuesta_estado;       // [ESTUDIO] responde al navegador con el HTML de estado
?>
