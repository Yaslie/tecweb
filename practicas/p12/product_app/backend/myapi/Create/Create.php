<?php
namespace TECWEB\MYAPI\Create;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Create extends DataBase {

    public function __construct($db) {
        parent::__construct($db);
    }

    public function add($producto) {
        // Inicializar la respuesta predeterminada
        $data = array(
            'status' => 'error',
            'message' => 'Ya existe un producto con ese nombre'
        );

        // Verificar si el producto ya existe en la base de datos
        $sql = "SELECT * FROM productos WHERE nombre = '{$producto['nombre']}' AND eliminado = 0";
        $result = $this->conexion->query($sql);

        if ($result->num_rows == 0) {
            $this->conexion->set_charset("utf8");
            $sql = "INSERT INTO productos (id, nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                    VALUES (null, '{$producto['nombre']}', '{$producto['marca']}', '{$producto['modelo']}', {$producto['precio']}, 
                    '{$producto['detalles']}', {$producto['unidades']}, '{$producto['imagen']}', 0)";
            
            if ($this->conexion->query($sql)) {
                $data['status'] = "success";
                $data['message'] = "Producto agregado";
            } else {
                $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
            }
        }
        $result->free();
        $this->conexion->close();
        $this->data = $data;
    }



}


?>