<?php
    include "../manejoSesion.inc";   // [ESTUDIO] GUARDIA DE SESION: session_start + si no hay $_SESSION["identificativo"] redirige al login y hace exit
    include "../conexion.php";    // [ESTUDIO] datos de conexion y funciones auxiliares (esta una carpeta mas arriba)

    header("Content-Type: application/json; charset=utf-8");   // [ESTUDIO] avisa al navegador que la respuesta es JSON (no HTML)
    sleep(1);                                                  // [ESTUDIO] demora de 1 segundo a proposito

    $codCliente = isset($_POST['codCliente']) ? $_POST['codCliente'] : '';   // [ESTUDIO] cliente cuyo archivo se quiere ver

    $objSalida = new stdClass();   // [ESTUDIO] objeto generico vacio; sus propiedades se convierten en claves del JSON
    $objSalida->estado = "";       // [ESTUDIO] "ok" o mensaje de error
    $objSalida->mime = "";         // [ESTUDIO] tipo de archivo (image/png, application/pdf...)
    $objSalida->documento = "";    // [ESTUDIO] contenido del archivo en base64

    $dbh = abrirConexion($host, $dbname, $user, $password);   // [ESTUDIO] abre la conexion

    if ($dbh === null) {
        $objSalida->estado = "Error en la conexion";
    } else {
        try {                                                  // [ESTUDIO] con ERRMODE_EXCEPTION cualquier error de SQL cae en el catch
            $stmt = $dbh->prepare("select fotoPuntoEntrega from clientes where codCliente = :codCliente");   // [ESTUDIO] trae solo la columna binaria
            $stmt->bindParam(':codCliente', $codCliente);      // [ESTUDIO] vincula la variable al marcador (por referencia)
            $stmt->setFetchMode(PDO::FETCH_ASSOC);             // [ESTUDIO] cada fila vuelve como arreglo asociativo (clave = nombre de columna)
            $stmt->execute();                                  // [ESTUDIO] ejecuta la consulta
            $fila = $stmt->fetch();                            // [ESTUDIO] toma una fila (false si no hay resultados)

            if ($fila === false || $fila['fotoPuntoEntrega'] === null) {   // [ESTUDIO] no existe el cliente o no tiene archivo cargado
                $objSalida->estado = "El registro no tiene archivo asociado";
            } else {
                // El binario viaja en base64 para que no se confunda con HTML. El tipo
                // se detecta del contenido, asi sirve tanto para PDF como para imagenes.
                $finfo = new finfo(FILEINFO_MIME_TYPE);                                 // [ESTUDIO] detector de tipo MIME por contenido
                $objSalida->mime = $finfo->buffer($fila['fotoPuntoEntrega']);           // [ESTUDIO] analiza los bytes y devuelve el MIME
                $objSalida->documento = base64_encode($fila['fotoPuntoEntrega']);       // [ESTUDIO] binario -> texto seguro para JSON
                $objSalida->estado = "ok";
            }
        } catch (PDOException $e) {
            escribirLog("Error al ejecutar la sentencia (traeDoc): " . $e->getMessage());   // [ESTUDIO] detalle tecnico al log, mensaje generico al usuario
            $objSalida->estado = "Error al ejecutar la sentencia";
        }
    }

    $dbh = null;   // [ESTUDIO] cierra la conexion
    echo json_encode($objSalida, JSON_INVALID_UTF8_SUBSTITUTE);   // [ESTUDIO] objeto -> texto JSON; la opcion reemplaza bytes UTF-8 invalidos en vez de fallar
?>
