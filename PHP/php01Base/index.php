<!-- Marca de comienzo del documento. No es una etiqueta -->
<!DOCTYPE html>

<html lang="es">

<head>
    <meta http-equiv="Content-Type" content="text/html;charset=utf-8" />

    <title>php01 - PHP basico: variables, tipos y arreglos</title>

    <meta name="addsearch-category" content="PHP, variables, tipos, arreglos, constantes, GLOBALS" />

    <link rel="stylesheet" type="text/css" href="./estilo.css">
</head>

<body>

    <header>
        <h1>PHP basico</h1>
    </header>

    <hr />

    <main>

        <!-- ================================================================
             1) Texto fuera y dentro del marcado PHP (pag. 1 del apunte)
             ================================================================ -->
        <section>
            <h2>1) Texto fuera y dentro del marcado PHP</h2>

            <!-- Este parrafo esta escrito directamente en HTML, fuera de
                 cualquier <?php ?>: el preprocesador PHP no lo toca y lo
                 entrega tal cual al navegador remoto. -->
            <p>
                Este parrafo esta escrito fuera de las marcas de PHP: es HTML puro que el
                procesador ignora y entrega directamente al navegador.
            </p>

            <?php
                // Esto en cambio es codigo PHP: el procesador lo INTERPRETA
                // antes de mandar nada al navegador. La sentencia echo permite
                // enviar texto/HTML "como si" estuviera afuera del marcado (pag. 2).
                echo "<p>Este otro parrafo lo genera PHP con un <strong>echo</strong>, desde ADENTRO del marcado.</p>";

                // El comillado interno se hace con comillas simples para no
                // cortar el comillado externo (doble), como dice el apunte.
                echo '<p style="color:green">Un parrafo en verde, comillado con simples adentro de dobles.</p>';
            ?>
        </section>

        <hr />

        <!-- ================================================================
             2) Variable de tipo string
             ================================================================ -->
        <section>
            <h2>2) Variable de tipo string</h2>

            <?php
                // TODAS las variables de PHP llevan el $ adelante. No existe
                // palabra clave para declararlas: se declaran solas al
                // asignarles un valor (pag. 2 del apunte).
                $a = "uno";
            ?>

            <p>
                <span class="nombreVariable">$a</span> =
                <span class="valorVariable"><?php echo $a; ?></span>
                (tipo: <?php echo gettype($a); ?>)
            </p>
        </section>

        <hr />

        <!-- ================================================================
             3) Variables enteras y suma
             ================================================================ -->
        <section>
            <h2>3) Variables enteras y suma</h2>

            <?php
                $b = 2;
                $c = 3;

                // PHP es de tipado DINAMICO pero FUERTE: si $b y $c fueran de
                // tipos incompatibles, esta suma tiraria error (a diferencia
                // de JavaScript, que hace coercion silenciosa entre tipos).
                $d = $b + $c;
            ?>

            <p><span class="nombreVariable">$b</span> = <span class="valorVariable"><?php echo $b; ?></span> (tipo: <?php echo gettype($b); ?>)</p>
            <p><span class="nombreVariable">$c</span> = <span class="valorVariable"><?php echo $c; ?></span> (tipo: <?php echo gettype($c); ?>)</p>
            <p><span class="nombreVariable">$d = $b + $c</span> = <span class="valorVariable"><?php echo $d; ?></span> (tipo: <?php echo gettype($d); ?>)</p>
        </section>

        <hr />

        <!-- ================================================================
             4) Variables logicas (booleanas)
             ================================================================ -->
        <section>
            <h2>4) Variables logicas (booleanas)</h2>

            <?php
                $e = true;
                $f = false;
                // OJO: el echo de un true imprime "1". El echo de un false
                // imprime una cadena vacia, por eso se lo muestra entre
                // comillas para que la ausencia de caracter se note.
            ?>

            <p><span class="nombreVariable">$e = true</span> &rarr; echo: "<span class="valorVariable"><?php echo $e; ?></span>" (tipo: <?php echo gettype($e); ?>)</p>
            <p><span class="nombreVariable">$f = false</span> &rarr; echo: "<span class="valorVariable"><?php echo $f; ?></span>" (tipo: <?php echo gettype($f); ?>)</p>
        </section>

        <hr />

        <!-- ================================================================
             5) Constantes
             ================================================================ -->
        <section>
            <h2>5) Constantes</h2>

            <?php
                // define(nombre, valor): las constantes NO llevan $ adelante
                // y, a diferencia de una variable, no pueden reasignarse
                // despues de definidas (pag. 3 del apunte).
                define("NOMBRE_CONSTANTE", "valorConstante");
            ?>

            <p>
                <span class="nombreVariable">NOMBRE_CONSTANTE</span> =
                <span class="valorVariable"><?php echo NOMBRE_CONSTANTE; ?></span>
                (tipo: <?php echo gettype(NOMBRE_CONSTANTE); ?>)
            </p>
        </section>

        <hr />

        <!-- ================================================================
             6) Arreglo de indice numerico
             ================================================================ -->
        <section>
            <h2>6) Arreglo de indice numerico</h2>

            <?php
                // Arreglo de indice numerico: un vector con elementos del
                // mismo tipo, cargado por asignacion directa (pag. 3).
                $saludo = ["Hola", "Hello"];

                // array_push agrega un elemento al final. Los dos argumentos
                // son la variable array y el valor a agregar.
                array_push($saludo, "Ciao");
                array_push($saludo, "Bonjour");
            ?>

            <ul>
                <?php
                    // Barrido del arreglo con foreach para mostrar cada
                    // elemento (pag. 4 del apunte).
                    foreach ($saludo as $palabra) {
                        echo "<li>" . $palabra . "</li>";
                    }
                ?>
            </ul>

            <p>gettype($saludo) = <?php echo gettype($saludo); ?> - count($saludo) = <?php echo count($saludo); ?></p>
        </section>

        <hr />

        <!-- ================================================================
             7) Arreglo de arreglos (dos dimensiones)
             ================================================================ -->
        <section>
            <h2>7) Arreglo de arreglos (dos dimensiones)</h2>

            <?php
                // Un arreglo de arreglos: cada renglon es a su vez un array
                // indexado con la misma palabra en 4 idiomas (pag. 4).
                $diccionario = [
                    ["Saludo", "Hola", "Hello", "Ciao", "Bonjour"],
                    ["Vivienda", "Casa", "House", "Casa", "Maison"],
                ];
            ?>

            <table>
                <tr>
                    <th>Concepto</th>
                    <th>Español</th>
                    <th>Ingles</th>
                    <th>Italiano</th>
                    <th>Frances</th>
                </tr>
                <?php
                    // foreach anidado: el externo recorre los renglones, el
                    // interno recorre cada palabra dentro del renglon.
                    foreach ($diccionario as $fila) {
                        echo "<tr>";
                        foreach ($fila as $celda) {
                            echo "<td>" . $celda . "</td>";
                        }
                        echo "</tr>";
                    }
                ?>
            </table>

            <p>$diccionario[1][2] &rarr; <?php echo $diccionario[1][2]; ?></p>
        </section>

        <hr />

        <!-- ================================================================
             8) Arreglo asociativo
             ================================================================ -->
        <section>
            <h2>8) Arreglo asociativo</h2>

            <?php
                // Arreglo asociativo: en vez de indice numerico, cada
                // elemento tiene una clave de tipo string (pag. 5).
                $persona = ["nombre" => "Guillermo", "apellido" => "Perez", "edad" => 30];
            ?>

            <p><span class="nombreVariable">$persona['nombre']</span> = <span class="valorVariable"><?php echo $persona['nombre']; ?></span> (tipo: <?php echo gettype($persona['nombre']); ?>)</p>
            <p><span class="nombreVariable">$persona['apellido']</span> = <span class="valorVariable"><?php echo $persona['apellido']; ?></span> (tipo: <?php echo gettype($persona['apellido']); ?>)</p>
            <p><span class="nombreVariable">$persona['edad']</span> = <span class="valorVariable"><?php echo $persona['edad']; ?></span> (tipo: <?php echo gettype($persona['edad']); ?>)</p>
            <p>count($persona) = <?php echo count($persona); ?></p>
        </section>

        <hr />

        <!-- ================================================================
             9) Expresiones aritmeticas
             ================================================================ -->
        <section>
            <h2>9) Expresiones aritmeticas</h2>

            <?php
                $x = 3;
                $y = 4;
                $suma = ($x + $y);     // los parentesis conservan el tipo de la suma
                $producto = $x * $y;
                $cociente = $x / $y;
            ?>

            <p><span class="nombreVariable">$x + $y</span> = <span class="valorVariable"><?php echo $suma; ?></span> (tipo: <?php echo gettype($suma); ?>)</p>
            <p><span class="nombreVariable">$x * $y</span> = <span class="valorVariable"><?php echo $producto; ?></span> (tipo: <?php echo gettype($producto); ?>)</p>
            <p><span class="nombreVariable">$x / $y</span> = <span class="valorVariable"><?php echo $cociente; ?></span> (tipo: <?php echo gettype($cociente); ?>)</p>
        </section>

        <hr />

        <!-- ================================================================
             10) Alcance de variables y $GLOBALS
             ================================================================ -->
        <section>
            <h2>10) Alcance de variables y $GLOBALS</h2>

            <?php
                // Toda variable declarada fuera de una funcion tiene alcance
                // GLOBAL. Ademas, PHP las guarda en el arreglo asociativo
                // $GLOBALS[], indexado por el nombre de cada variable (sin $).
                $n1 = 40;
                $n2 = 50;

                function sumarGlobales() {
                    // Dentro de una funcion NO se ve $n1 ni $n2 directamente:
                    // hay que pasar por $GLOBALS para llegar a ellas.
                    $resultadoLocal = $GLOBALS['n1'] + $GLOBALS['n2'];

                    // $resultadoLocal solo existe DENTRO de esta funcion: su
                    // alcance es local y muere al terminar sumarGlobales().
                    return $resultadoLocal;
                }

                $resultado = sumarGlobales();
            ?>

            <p>$GLOBALS['n1'] = <?php echo $GLOBALS['n1']; ?></p>
            <p>$GLOBALS['n2'] = <?php echo $GLOBALS['n2']; ?></p>
            <p>sumarGlobales() = <span class="valorVariable"><?php echo $resultado; ?></span></p>
        </section>

    </main>

    <hr />

    <footer>
        <p><a href="../index.html">Volver al indice de PHP</a></p>

        Santiago Cannistra
        <address>
            Programación en Ambiente de Redes
        </address>
    </footer>

</body>
</html>
