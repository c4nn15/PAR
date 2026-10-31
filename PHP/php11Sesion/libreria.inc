<?php
    include_once __DIR__ . "/conexion.php";

    // Devuelve true si el login y la clave corresponden a un usuario de la tabla usuarios.
    // Si valida, deja en $argUsuario la fila del usuario (idUsuario, contador, etc.).
    function autenticacion($argLogin, $argClave, &$argUsuario) {
        global $host, $dbname, $user, $password;
        $aceptado = false;
        $dbh = abrirConexion($host, $dbname, $user, $password);
        if ($dbh === null) {
            return false;
        }
        try {
            $stmt = $dbh->prepare("select idUsuario, loginUsuario, apellido, nombres, clave, contador from usuarios where loginUsuario=:login");
            $stmt->execute([":login" => $argLogin]);
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($fila && hash_equals($fila['clave'], hash('sha256', $argClave))) {
                $argUsuario = $fila;
                $aceptado = true;
            }
        } catch (PDOException $e) {
            escribirLog("autenticacion: " . $e->getMessage());
        }
        $dbh = null;
        return $aceptado;
    }

    // Suma 1 al contador de sesiones del usuario y devuelve el nuevo valor.
    function incrementaContador($argIdUsuario, $argContadorActual) {
        global $host, $dbname, $user, $password;
        $nuevo = $argContadorActual + 1;
        $dbh = abrirConexion($host, $dbname, $user, $password);
        if ($dbh !== null) {
            try {
                $stmt = $dbh->prepare("update usuarios set contador=:contador where idUsuario=:id");
                $stmt->execute([":contador" => $nuevo, ":id" => $argIdUsuario]);
            } catch (PDOException $e) {
                escribirLog("incrementaContador: " . $e->getMessage());
            }
            $dbh = null;
        }
        return $nuevo;
    }

    // Muestra los datos de la sesion actual.
    function infoDeSesion() {
        echo "<ul>\n";
        echo "<li>Identificativo de sesion: " . htmlspecialchars(session_id()) . "</li>\n";
        echo "<li>Identificativo en \$_SESSION: " . htmlspecialchars($_SESSION['identificativo']) . "</li>\n";
        echo "<li>Login de usuario: " . htmlspecialchars($_SESSION['login']) . "</li>\n";
        echo "<li>Contador de sesion: " . htmlspecialchars($_SESSION['ContadorDeSesion']) . "</li>\n";
        echo "</ul>\n";
    }
?>
