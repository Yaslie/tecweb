<?php

$link = mysqli_connect("localhost", "root", "Alaskita123", "marketzone");
if (!$link) {
    die("ERROR: No pudo conectarse con la BD. " . mysqli_connect_error());
}

$id = intval($_POST['id']);
$nombre = mysqli_real_escape_string($link, $_POST['nombre']);
$marca = mysqli_real_escape_string($link, $_POST['marca']);
$modelo = mysqli_real_escape_string($link, $_POST['modelo']);
$precio = floatval($_POST['precio']);
$unidades = intval($_POST['unidades']);
$detalles = mysqli_real_escape_string($link, $_POST['detalles']);
$imagenes = mysqli_real_escape_string($link, $_POST['imagenes']);

$sql = "UPDATE productos 
        SET nombre='$nombre', marca='$marca', modelo='$modelo', precio=$precio, 
            unidades=$unidades, detalles='$detalles', imagenes='$imagenes'
        WHERE id=$id";

if (mysqli_query($link, $sql)) {
    echo "Producto actualizado correctamente.<br>";
} else {
    echo "ERROR: No se pudo actualizar el producto. " . mysqli_error($link);
}

mysqli_close($link);

// Enlaces para volver
echo '<br><a href="get_productos_xhtml_v2.php">Volver a la lista de productos</a>';
echo '<br><a href="get_productos_vigentes_v2.php">Ver productos vigentes</a>';
?>
