<?php 
namespace TECWEB\MYAPI\Update;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Update extends DataBase {

    public function __construct($db) {
        parent::__construct($db);
    }

    public function edit($jsonOBJ) {
        $data = array(
            'status' => 'error',
            'message' => 'Datos incompletos o inválidos'
        );

        if (!empty($jsonOBJ)) {
            // Asegurarse de que los campos necesarios existen
            if (isset($jsonOBJ->id) && isset($jsonOBJ->nombre)) {
                $id = $jsonOBJ->id;
                $nombre = $jsonOBJ->nombre;

                // Verificar si el nombre del producto ya existe (excluyendo el producto actual)
                $sql = "SELECT * FROM productos WHERE nombre = '{$nombre}' AND id != {$id} AND eliminado = 0";
                $result = $this->conexion->query($sql);

                if ($result->num_rows == 0) {
                    $this->conexion->set_charset("utf8");

                    // Actualizar el producto en la base de datos
                    $sql = "UPDATE productos SET 
                        nombre = '{$nombre}', 
                        marca = '{$jsonOBJ->marca}', 
                        modelo = '{$jsonOBJ->modelo}', 
                        precio = {$jsonOBJ->precio}, 
                        detalles = '{$jsonOBJ->detalles}', 
                        unidades = {$jsonOBJ->unidades}, 
                        imagen = '{$jsonOBJ->imagen}' 
                        WHERE id = {$id}";

                    if ($this->conexion->query($sql) === TRUE) {
                        $data['status'] = "success";
                        $data['message'] = "Producto editado exitosamente";
                    } else {
                        $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
                    }
                } else {
                    $data['message'] = "Ya existe un producto con ese nombre";
                }

                $result->free();
            }
        }
        // Responder con el estado de la operación
        $this->data = $data;
    }

}
?>