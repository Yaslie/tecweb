<?php 
namespace TECWEB\MYAPI\Delete;

use TECWEB\MYAPI\DataBase;
require_once __DIR__ . '/../DataBase.php';

class Delete extends DataBase {

    public function __construct($db) {
        parent::__construct($db);
    }

    public function delete($id) {
        $data = array(
            'status' => 'error',
            'message' => 'Producto no encontrado'
        );
        $sql = "UPDATE productos SET eliminado = 1 WHERE id = {$id}";
        if ($this->conexion->query($sql)) {
            $data['status'] = 'success';
            $data['message'] = 'Producto eliminado';
        } else {
            $data['message'] = 'ERROR: No se ejecutó ' . $sql . '. ' . mysqli_error($this->conexion);
        }
        $this->data = $data;
        $this->conexion->close();
    }
}
?>