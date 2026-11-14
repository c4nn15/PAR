<?php
    include_once __DIR__ . "/conexion.php";   // [ESTUDIO] trae $host/$dbname/... y abrirConexion; include_once evita cargarlo dos veces; __DIR__ = carpeta de este archivo

    // Devuelve true si el login y la clave corresponden a un usuario de la tabla usuarios.
    // Si valida, deja en $argUsuario la fila del usuario (idUsuario, contador, etc.).
    function autenticacion($argLogin, $argClave, &$argUsuario) {   // [ESTUDIO] &$argUsuario por referencia: la funcion devuelve true/false y ademas "entrega" el usuario por este parametro
        global $host, $dbname, $user, $password;                   // [ESTUDIO] dentro de una funcion hay que declarar global para ver variables de afuera
        $aceptado = false;                                         // [ESTUDIO] por defecto, rechazado
        $dbh = abrirConexion($host, $dbname, $user, $password);    // [ESTUDIO] abre la conexion PDO
        if ($dbh === null) {                                       // [ESTUDIO] sin conexion no se puede autenticar
            return false;
        }
        try {
            $stmt = $dbh->prepare("select idUsuario, loginUsuario, apellido, nombres, clave, contador from usuarios where loginUsuario=:login");   // [ESTUDIO] busca al usuario por login (marcador :login, sin concatenar)
            $stmt->execute([":login" => $argLogin]);               // [ESTUDIO] ejecuta pasando el valor directamente en un arreglo
            $fila = $stmt->fetch(PDO::FETCH_ASSOC);                // [ESTUDIO] toma la fila como arreglo asociativo (false si no existe el login)
            if ($fila && hash_equals($fila['clave'], hash('sha256', $argClave))) {   // [ESTUDIO] existe el usuario Y el hash SHA-256 de la clave ingresada coincide con el guardado; hash_equals compara en tiempo constante (evita ataques de timing)
                $argUsuario = $fila;                               // [ESTUDIO] devuelve los datos del usuario al llamador
                $aceptado = true;
            }
        } catch (PDOException $e) {
            escribirLog("autenticacion: " . $e->getMessage());     // [ESTUDIO] error al log
        }
        $dbh = null;                                               // [ESTUDIO] cierra la conexion
        return $aceptado;                                          // [ESTUDIO] true si las credenciales eran validas
    }

    // Suma 1 al contador de sesiones del usuario y devuelve el nuevo valor.
    function incrementaContador($argIdUsuario, $argContadorActual) {
        global $host, $dbname, $user, $password;
        $nuevo = $argContadorActual + 1;                           // [ESTUDIO] calcula el nuevo valor
        $dbh = abrirConexion($host, $dbname, $user, $password);
        if ($dbh !== null) {
            try {
                $stmt = $dbh->prepare("update usuarios set contador=:contador where idUsuario=:id");   // [ESTUDIO] guarda el contador en la base
                $stmt->execute([":contador" => $nuevo, ":id" => $argIdUsuario]);
            } catch (PDOException $e) {
                escribirLog("incrementaContador: " . $e->getMessage());
            }
            $dbh = null;
        }
        return $nuevo;                                             // [ESTUDIO] devuelve el nuevo contador (se guarda en $_SESSION)
    }

    // Muestra los datos de la sesion actual.
    function infoDeSesion() {
        echo "<ul>\n";                                                                                              // [ESTUDIO] abre la lista HTML
        echo "<li>Identificativo de sesion: " . htmlspecialchars(session_id()) . "</li>\n";                         // [ESTUDIO] session_id() = id real de la sesion (el de la cookie)
        echo "<li>Identificativo en \$_SESSION: " . htmlspecialchars($_SESSION['identificativo']) . "</li>\n";     // [ESTUDIO] el que genero el script con session_create_id (\$ escapa el signo para que se imprima literal)
        echo "<li>Login de usuario: " . htmlspecialchars($_SESSION['login']) . "</li>\n";
        echo "<li>Contador de sesion: " . htmlspecialchars($_SESSION['ContadorDeSesion']) . "</li>\n";
        echo "</ul>\n";
    }
?>
