<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 5 – Variables en PHP</title>
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
</body>
</html>
