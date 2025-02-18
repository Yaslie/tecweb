<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 4 – Variables en PHP</title>
</head>
<body>
    <h2>Ejercicio 1: Variables válidas e inválidas</h2>

    <?php
        // Variables de prueba
        $_myvar = "Válida";     // Correcta: inicia con _
        $_7var = "Válida";      // Correcta: inicia con _
        // myvar = "Inválida";  // Incorrecta: falta el $
        $myvar = "Válida";      // Correcta: inicia con letra
        $var7 = "Válida";       // Correcta: inicia con letra
        $_element1 = "Válida";  // Correcta: inicia con _
        // $house*5 = "Inválida"; // Incorrecta: * no se permite en nombres

        echo "<ul>";
        echo "<li>\$_myvar es válida porque inicia con un guion bajo.</li>";
        echo "<li>\$_7var es válida porque inicia con un guion bajo.</li>";
        echo "<li>myvar es inválida porque no tiene el signo de dólar (\$).</li>";
        echo "<li>\$myvar es válida porque inicia con una letra.</li>";
        echo "<li>\$var7 es válida porque inicia con una letra.</li>";
        echo "<li>\$_element1 es válida porque inicia con un guion bajo.</li>";
        echo "<li>\$house*5 es inválida porque el símbolo * no está permitido en nombres de variables.</li>";
        echo "</ul>";

        // Liberar variables
        unset($_myvar, $_7var, $myvar, $var7, $_element1);
    ?>

<?php
    echo "<h2>Ejercicio 2: Valores de variables</h2>";

    // Definición de variables
    $a = "ManejadorSQL";
    $b = 'MySQL';
    $c = &$a; // Referencia

    echo "<p>Valores iniciales:</p>";
    echo "<ul>";
    echo "<li>a: $a</li>";
    echo "<li>b: $b</li>";
    echo "<li>c: $c</li>";
    echo "</ul>";

    $a = "PHP server";
    $b = &$a;

    echo "<p>Valores después de la nueva asignación:</p>";
    echo "<ul>";
    echo "<li>a: $a</li>";
    echo "<li>b: $b</li>";
    echo "<li>c: $c</li>";
    echo "</ul>";

    echo "<p>Explicación: Como \$c es una referencia a \$a, cualquier cambio en \$a afecta a \$c.</p>";

    // Liberar varables
    unset($a, $b, $c);
?>


<?php
    echo "<h2>Ejercicio 3: Evolución de Variables</h2>";

    $a = "PHP5";
    @$z[] = &$a;
    $b = "5a version de PHP";
    @$c = $b * 10;
    $a .= $b;
    @$b *= $c;
    $z[0] = "MySQL";

    echo "<pre>";
    print_r(compact('a', 'b', 'c', 'z'));
    echo "</pre>";

    unset($a, $b, $c, $z);
?>

<?php
    echo "<h2>Ejercicio 4: Uso de \$GLOBALS y global</h2>";

    // Definición de variables globales
    $a = "PHP5";
    $z[] = &$a;
    $b = "5a version de PHP";
    @$c = $b * 10;
    $a .= $b;
    @$b *= $c;
    $z[0] = "MySQL";

    echo "<h3>Usando \$GLOBALS:</h3>";
    echo "<pre>";
    print_r(array(
        "a" => $GLOBALS['a'],
        "b" => $GLOBALS['b'],
        "c" => $GLOBALS['c'],
        "z" => $GLOBALS['z']
    ));
    echo "</pre>";

    function mostrarVariables() {
        global $a, $b, $c, $z;
        echo "<h3>Usando global:</h3>";
        echo "<pre>";
        print_r(compact('a', 'b', 'c', 'z'));
        echo "</pre>";
    }

    mostrarVariables();

    // Liberar variables
    unset($a, $b, $c, $z);
?>

<?php
    echo "<h2>Ejercicio 5: Casting de Tipos</h2>";

    $a = "7 personas";
    $b = (integer) $a;
    $a = "9E3";
    $c = (double) $a;

    echo "<ul>";
    echo "<li>a: $a</li>"; // 9000
    echo "<li>b: $b</li>"; // 7
    echo "<li>c: $c</li>"; // 9000.0
    echo "</ul>";
    unset($a, $b, $c);
?>

<?php
    echo "<h2>Ejercicio 6: Valores Booleanos</h2>";

    $a = "0";      
    $b = "TRUE";    
    $c = FALSE;    
    $d = ($a OR $b);
    $e = ($a AND $c);
    $f = ($a XOR $b);

    echo "<h3>Valores Booleanos con var_dump:</h3>";
    echo "<pre>";
    var_dump($a, $b, $c, $d, $e, $f);
    echo "</pre>";

    echo "<h3>Valores convertidos a string:</h3>";
    echo "<ul>";
    echo "<li>c: " . json_encode($c) . "</li>";
    echo "<li>e: " . json_encode($e) . "</li>";
    echo "</ul>";
    unset($a, $b, $c, $d, $e, $f);
?>

<?php
    echo "<h2>Ejercicio 7: Uso de \$_SERVER</h2>";

    echo "<ul>";
    echo "<li>Versión de Apache y PHP: " . $_SERVER['SERVER_SOFTWARE'] . "</li>";
    echo "<li>Nombre del sistema operativo: " . php_uname() . "</li>";
    echo "<li>Idioma del navegador: " . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . "</li>";
    echo "</ul>";
?>

<p>
    <a href="https://validator.w3.org/markup/check?uri=referer"><img
    src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
</p>
</body>
</html>