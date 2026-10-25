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
?>
