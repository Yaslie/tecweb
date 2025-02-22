<?php
@$link = new mysqli('localhost', 'root', 'Alaskita123', 'marketzone');

if ($link->connect_errno) {
    die('Error de conexión: ' . $link->connect_error);
}

$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen = $_POST['imagen'];

$sql_verificar = "SELECT * FROM productos WHERE nombre=? AND marca=? AND modelo=?";
$stmt = $link->prepare($sql_verificar);
$stmt->bind_param("sss", $nombre, $marca, $modelo);
$stmt->execute();
$resultado = $stmt->get_result();

if ($resultado->num_rows > 0) {
    die("Error: El producto ya está registrado.");
}

$sql_insert = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
        VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
$stmt = $link->prepare($sql_insert);
$stmt->bind_param("sssdsis", $nombre, $marca, $modelo, $precio, $detalles, $unidades, $imagen);

if ($stmt->execute()) {
    echo "Producto registrado con éxito. ID: " . $stmt->insert_id;
} else {
    echo "Error al registrar el producto.";
}

$link->close();
?>
