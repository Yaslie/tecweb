<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 3</title>
</head>
<body>

    <?php
        use EJEMPLOS\POO\Cabecera2 as Cabecera;
        require_once __DIR__ . '/Cabecera.php';

        /*$cap1 = new Cabecera('El rincon del programador', 'center');
        $cap1->graficar();*/

        $cap1 = new Cabecera('El rincon del programador', 'center', 'https://www.deepseek.com');
        $cap1->graficar();
    ?>

</body>
</html>