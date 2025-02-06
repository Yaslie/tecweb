<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>

<!--ejercicio 1 inicio-->
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>
    
    <?php
        require_once __DIR__ . '/src/funciones.php';
        if (isset($_GET['numero']) && is_numeric($_GET['numero'])) {
            $num = intval($_GET['numero']);
            es_multiplo($num);
        }
    ?>
    <form method="get">
        <label for="numero">Ingresa un número:</label>
        <input type="text" name="numero" id="numero">
        <input type="submit" value="Comprobar">
    </form>
    <hr>
<!--ejercicio 1 final-->


<!--ejercicio 2 inicio-->
    <h2>Ejercicio 2: Generación de secuencia impar, par, impar</h2>
    <form method="get">
        <input type="hidden" name="ejercicio2" value="1">
        <input type="submit" value="Generar Secuencia">
    </form>
    <?php
    if (isset($_GET['ejercicio2'])) {
        require_once 'src/funciones.php';
        $resultado = generar_secuencia();
        echo "<h3>Secuencia generada:</h3><pre>";
        foreach ($resultado['secuencia'] as $fila) {
            echo implode(", ", $fila) . "<br>";
        }
        echo "</pre>";
        echo "<p>Total de números generados: {$resultado['total_numeros']}</p>";
        echo "<p>Número de iteraciones: {$resultado['iteraciones']}</p>";
    }
    ?>
    <hr>
<!--ejercicio 2 final-->


<!--ejercicio 3 inicio-->
<h2>Ejercicio 3: Buscar múltiplo de un número dado (usando while)</h2>
    <form method="get">
        <label for="multiplo">Número para encontrar múltiplo:</label>
        <input type="number" name="multiplo" id="multiplo">
        <input type="submit" value="Buscar Múltiplo">
    </form>
    <?php
    if (isset($_GET['multiplo']) && is_numeric($_GET['multiplo'])) {
        require_once 'src/funciones.php';
        echo buscar_multiplo($_GET['multiplo']);
    }
    ?>
    <hr>
<!--ejercicio 3 final-->


<!--ejercicio 4 inicio-->
<h2>Ejercicio 4: Crear y mostrar arreglo con letras de a => z</h2>
    <?php
    require_once 'src/funciones.php';
    $arreglo_letras = crear_arreglo_letras();
    echo "<h3>Arreglo de letras:</h3><table border='1'>
            <tr><th>Índice</th><th>Letra</th></tr>";
    foreach ($arreglo_letras as $key => $value) {
        echo "<tr><td>$key</td><td>$value</td></tr>";
    }
    echo "</table>";
    ?>
    <hr>
<!--ejercicio 4 final-->


<!--ejemplo post inicio-->
<h2>Ejemplo de POST</h2>
    <form action="http://localhost/tecweb/practicas/p04/index.php" method="post">
        Name: <input type="text" name="name"><br>
        E-mail: <input type="text" name="email"><br>
        <input type="submit">
    </form>
    <br>
    <?php
        if (isset($_POST["name"]) && isset($_POST["email"])) {
            echo "<h3>Nombre: " . htmlspecialchars($_POST["name"]) . "</h3>";
            echo "<h3>Email: " . htmlspecialchars($_POST["email"]) . "</h3>";
        }
    ?>
<!--ejemplo post final-->
</body>
</html>