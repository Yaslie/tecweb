<?php
namespace TECWEB\MYAPI\Read;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Read extends DataBase {

    public function __construct($db) {
        parent::__construct($db);
    }

    public function list() {
        $data = array();
        if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
            // Obtener los resultados
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                // Mapear los resultados al arreglo de respuesta
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $data[$num][$key] = $value;
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
        $this->data = $data;
    }

    public function search($search) {
        $data = array();
        $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
        
        if ($result = $this->conexion->query($sql)) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            if (!is_null($rows)) {
                foreach ($rows as $num => $row) {
                    foreach ($row as $key => $value) {
                        $data[$num][$key] = utf8_encode($value);
                    }
                }
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($this->conexion));
        }
        // Asignar los resultados a la propiedad de respuesta
        $this->data = $data;
    }

    public function single($id) {
        $data = array();

        // Evitar inyección de SQL con parámetros preparados
        $query = "SELECT * FROM productos WHERE id = ?";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param('i', $id);  // 'i' indica que el parámetro es un entero
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result) {
            // Obtener los resultados y mapearlos al arreglo de respuesta
            if ($row = $result->fetch_assoc()) {
                $data = array(
                    'id' => $row['id'],
                    'nombre' => $row['nombre'],
                    'marca' => $row['marca'],
                    'modelo' => $row['modelo'],
                    'precio' => $row['precio'],
                    'detalles' => $row['detalles'],
                    'unidades' => $row['unidades'],
                    'imagen' => $row['imagen']
                );
            }
            $result->free();
        } else {
            die('Query fallida');
        }

        // Asignar los resultados a la propiedad de respuesta
        $this->data = $data;
    }

}
?>