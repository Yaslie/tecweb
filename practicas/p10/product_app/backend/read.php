<?php
include_once __DIR__.'/database.php';

// SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
$data = [];

// SE OBTIENE LA CONEXIÓN CORRECTA
$db = new Database();
$conn = $db->getConnection();

if (!$conn) {
    die(json_encode(["error" => " No se pudo conectar a la base de datos."]));
}

// SE VERIFICA SI SE RECIBIÓ UN ID O UN TÉRMINO DE BÚSQUEDA
if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // Se convierte a entero para evitar problemas
    $sql = "SELECT * FROM productos WHERE id = ? AND eliminado = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
} elseif (isset($_POST['q'])) { 
    $busqueda = $conn->real_escape_string($_POST['q']);
    $sql = "SELECT * FROM productos 
            WHERE (nombre LIKE ? 
               OR marca LIKE ? 
               OR detalles LIKE ?) 
              AND eliminado = 0";
    $stmt = $conn->prepare($sql);
    $param = "%$busqueda%";
    $stmt->bind_param("sss", $param, $param, $param);
} else {
    die(json_encode(["error" => " No se recibió un parámetro válido."]));
}

// SE EJECUTA LA CONSULTA Y SE OBTIENEN LOS RESULTADOS
if ($stmt->execute()) {
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
} else {
    die(json_encode(["error" => " Error en la consulta de productos."]));
}

// SE CIERRA LA CONEXIÓN Y SE DEVUELVE LA RESPUESTA EN JSON
$stmt->close();
$conn->close();
echo json_encode($data, JSON_PRETTY_PRINT);
?>
