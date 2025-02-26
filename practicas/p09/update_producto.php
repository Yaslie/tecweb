<?php

$link = mysqli_connect("localhost", "root", "Alaskita123", "marketzone");

if ($link === false) {
    die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'];
    $nombre = $_POST['nombre'];
    $marca = $_POST['marca'];
    $modelo = $_POST['modelo'];
    $precio = $_POST['precio'];
    $unidades = $_POST['unidades'];
    $detalles = $_POST['detalles'];
    $imagenes = $_POST['imagenes'];

    // Query para actualizar el producto
    $sql = "UPDATE productos SET 
                nombre='$nombre', 
                marca='$marca', 
                modelo='$modelo', 
                precio=$precio, 
                unidades=$unidades, 
                detalles='$detalles', 
                imagenes='$imagenes' 
            WHERE id=$id";

    if (mysqli_query($link, $sql)) {
        echo "Producto actualizado correctamente. (≧◡≦)";
    } else {
        echo "ERROR: No se pudo actualizar el producto. " . mysqli_error($link);
    }
} else {
    echo "Acceso no válido.";
}

mysqli_close($link);
?>
