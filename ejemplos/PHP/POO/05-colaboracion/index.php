<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ejemplo 5</title>
</head>
<body>
    
    <?php
    require_once __DIR__ . '/Pagina.php';

    $pag1 = new Pagina('El techo del programador', 'El sotano del porgramador');

    for ($i=0; $i<15; $i++){
        $pag1->insertar_cuerpo('Este es el parrafo No.'.($i+1).' que debe aparecer en la pagina');
    }

    $pag1->graficar();
    ?>

</body>
</html>