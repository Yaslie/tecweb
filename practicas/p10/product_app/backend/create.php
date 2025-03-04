<?php
include_once __DIR__ . '/database.php';

$db = new Database();
$conn = $db->getConnection();

ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/error_log.txt');

error_reporting(E_ALL);
ini_set('display_errors', 1);

header('Content-Type: application/json');

// SE OBTIENE LA INFORMACIÓN DEL PRODUCTO ENVIADA POR EL CLIENTE
$producto = file_get_contents('php://input');

if (!empty($producto)) {
    $jsonOBJ = json_decode($producto);

    if (!$jsonOBJ) {
        echo json_encode(["error" => "❌ Error: Datos JSON no válidos."]);
        exit;
    }

    // Extraer datos del objeto JSON
    $nombre = trim($jsonOBJ->nombre ?? '');
    $marca = trim($jsonOBJ->marca ?? '');
    $modelo = trim($jsonOBJ->modelo ?? '');
    $precio = floatval($jsonOBJ->precio ?? 0);
    $unidades = intval($jsonOBJ->unidades ?? 0);
    $detalles = trim($jsonOBJ->detalles ?? '');
    $imagenes = trim($jsonOBJ->imagen ?? 'img/default.png');

    // Validaciones
    if (!$nombre || strlen($nombre) > 100) {
        echo json_encode(["error" => "⚠️ Error: El nombre es obligatorio y debe tener 100 caracteres o menos."]);
        exit;
    }

    if (!$marca) {
        echo json_encode(["error" => "⚠️ Error: La marca es obligatoria."]);
        exit;
    }

    if (!$modelo || strlen($modelo) > 25 || !preg_match('/^[a-zA-Z0-9-]+$/', $modelo)) {
        echo json_encode(["error" => "⚠️ Error: El modelo es obligatorio, debe ser alfanumérico y tener 25 caracteres o menos."]);
        exit;
    }

    if ($precio <= 99.99) {
        echo json_encode(["error" => "⚠️ Error: El precio debe ser mayor a 99.99."]);
        exit;
    }

    if ($detalles && strlen($detalles) > 250) {
        echo json_encode(["error" => "⚠️ Error: Los detalles deben tener 250 caracteres o menos."]);
        exit;
    }

    if ($unidades < 0) {
        echo json_encode(["error" => "⚠️ Error: Las unidades deben ser un número mayor o igual a 0."]);
        exit;
    }

    // Conexión a la BD
    $db = new Database();
    $conn = $db->getConnection();

    if (!$conn) {
        echo json_encode(["error" => "❌ Error: No se pudo conectar a la base de datos."]);
        exit;
    }

    // Verificar si el producto ya existe
    $sqlCheck = "SELECT COUNT(*) as count FROM productos WHERE ((nombre = ? AND marca = ?) OR (marca = ? AND modelo = ?)) AND eliminado = 0";
    $stmtCheck = $conn->prepare($sqlCheck);
    $stmtCheck->bind_param("ssss", $nombre, $marca, $marca, $modelo);
    $stmtCheck->execute();
    $resultCheck = $stmtCheck->get_result()->fetch_assoc();

    if ($resultCheck['count'] > 0) {
        echo json_encode(["error" => "⚠️ Error: El producto ya existe en la base de datos."]);
        exit;
    }

    // Insertar el nuevo producto
    $sqlInsert = "INSERT INTO productos (nombre, marca, modelo, precio, unidades, detalles, imagenes, eliminado) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, 0)";
    $stmtInsert = $conn->prepare($sqlInsert);

    if ($stmtInsert) {
        //  AQUÍ ESTABA EL ERROR: Se agregó la "s" faltante en bind_param 
        $stmtInsert->bind_param("sssdiss", $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagenes);
        
        if ($stmtInsert->execute()) {
            echo json_encode(["success" => true, "mensaje" => "✅ Producto agregado exitosamente."]);
        } else {
            echo json_encode(["error" => "❌ Error al insertar el producto."]);
        }
    } else {
        echo json_encode(["error" => "❌ Error al preparar la consulta de inserción."]);
    }
}
?>
