<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = [];

// SE VERIFICA SI SE RECIBIÓ UN ID O UN TÉRMINO DE BÚSQUEDA
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Se convierte a entero para evitar problemas
    $sql = "SELECT * FROM productos WHERE id = $id AND eliminado = 0";

    if ($result = $conexion->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
} elseif (isset($_POST['q'])) { 
    $busqueda = $conexion->real_escape_string($_POST['q']);
    $sql = "SELECT * FROM productos 
            WHERE (nombre LIKE '%$busqueda%' 
               OR marca LIKE '%$busqueda%' 
               OR detalles LIKE '%$busqueda%') 
              AND eliminado = 0";

    if ($result = $conexion->query($sql)) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
        $result->free();
    } else {
        die('Query Error: ' . mysqli_error($conexion));
    }
}

// SE CIERRA LA CONEXIÓN Y SE DEVUELVE LA RESPUESTA EN JSON
$conexion->close();
echo json_encode($data, JSON_PRETTY_PRINT);
?>
