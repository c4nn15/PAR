<?php
    // Datos de conexion al motor MySQL. Para Clever Cloud reemplazar por los
    // valores de "Personal space" (ver Herramientas.pdf).
    $dbname   = "if0_42960923_par";
    $host     = "sql306.infinityfree.com";
    $user     = "if0_42960923";
    $password = "qQwV8vj790RCEIt";

    // Agrega una linea al archivo errores.log (modo "a" = adicion).
    function escribirLog($argTexto) {
        $puntero = fopen(__DIR__ . "/errores.log", "a");
        fwrite($puntero, date("Y-m-d H:i") . " " . $argTexto);
        fwrite($puntero, "\n");
        fclose($puntero);
    }

    // Abre la conexion PDO. Devuelve null (y deja registro en el log) si falla.
    function abrirConexion($argHost, $argDbname, $argUser, $argPassword) {
        try {
            $dsn = "mysql:host=$argHost;dbname=$argDbname;charset=utf8mb4";
            $dbh = new PDO($dsn, $argUser, $argPassword);
            $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $dbh;
        } catch (PDOException $e) {
            escribirLog("Error en la conexion: " . $e->getMessage());
            return null;
        }
    }

    // Prepara, vincula y ejecuta una sentencia, cada etapa en su try/catch, y va
    // concatenando el resultado en $argEstado (se muestra en la ventana de respuesta).
    // $argParametros: [":nombre" => valor] o [":nombre" => [valor, PDO::PARAM_xxx]].
    function ejecutarConEstado($argDbh, $argSql, $argParametros, &$argEstado) {
        try {
            $stmt = $argDbh->prepare($argSql);
            $argEstado = $argEstado . "Preparacion exitosa!<br />\n";
        } catch (PDOException $e) {
            escribirLog("Error en prepare: " . $e->getMessage());
            $argEstado = $argEstado . "Error en la preparacion: " . $e->getMessage() . "<br />\n";
            return false;
        }
        try {
            foreach ($argParametros as $nombre => $dato) {
                if (is_array($dato)) {
                    $stmt->bindValue($nombre, $dato[0], $dato[1]);
                } else {
                    $stmt->bindValue($nombre, $dato);
                }
            }
            $argEstado = $argEstado . "Vinculacion exitosa!<br />\n";
        } catch (PDOException $e) {
            escribirLog("Error en bind: " . $e->getMessage());
            $argEstado = $argEstado . "Error en la vinculacion: " . $e->getMessage() . "<br />\n";
            return false;
        }
        try {
            $stmt->execute();
            $argEstado = $argEstado . "Ejecucion exitosa! Filas afectadas: " . $stmt->rowCount() . "<br />\n";
        } catch (PDOException $e) {
            escribirLog("Error en execute: " . $e->getMessage());
            $argEstado = $argEstado . "Error en la ejecucion: " . $e->getMessage() . "<br />\n";
            return false;
        }
        return true;
    }

    // Segunda etapa de alta/modi: si llego un archivo en el input "fotoPuntoEntrega"
    // se guarda en el campo binario del registro. Se hace aparte de los datos simples.
    function actualizaBinario($argDbh, $argCodCliente, &$argEstado) {
        $argEstado = $argEstado . "<br />Parte registro documento binario<br />\n";
        if (!isset($_FILES['fotoPuntoEntrega'])) {
            $argEstado = $argEstado . "No se inicializo global \$_FILES<br />\n";
            return;
        }
        $arch = $_FILES['fotoPuntoEntrega'];
        $argEstado = $argEstado . "name: " . htmlspecialchars($arch['name']) . "<br />\n";
        $argEstado = $argEstado . "type: " . htmlspecialchars($arch['type']) . "<br />\n";
        $argEstado = $argEstado . "size: " . $arch['size'] . "<br />\n";
        $argEstado = $argEstado . "tmp_name: " . htmlspecialchars($arch['tmp_name']) . "<br />\n";
        if (empty($arch['name'])) {
            $argEstado = $argEstado . "No ha sido seleccionado ningun file para enviar!<br />\n";
            return;
        }
        if ($arch['error'] !== UPLOAD_ERR_OK) {
            $argEstado = $argEstado . "Error en la subida del archivo (codigo " . $arch['error'] . ")<br />\n";
            return;
        }
        $contenido = file_get_contents($arch['tmp_name']);
        $sql = "update clientes set fotoPuntoEntrega=:foto where codCliente=:codCliente";
        $ok = ejecutarConEstado($argDbh, $sql, [":foto" => [$contenido, PDO::PARAM_LOB], ":codCliente" => $argCodCliente], $argEstado);
        if ($ok) {
            $argEstado = $argEstado . "Contenido del archivo asociado ha sido registrado.<br />\n";
        }
    }
?>
