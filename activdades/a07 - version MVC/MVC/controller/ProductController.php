<?php
namespace TECWEB\CONTROLLER;

use TECWEB\MYAPI\Products;

class ProductController {

    // Método para agregar un producto
    public function addProduct($data) {
        $productos = new Products('marketzone');
        $productos->add($data);  // Llamada al método add de Products
        echo $productos->getData();  // Devuelve la respuesta al frontend
    }

    // Método para eliminar un producto
    public function deleteProduct($id) {
        $productos = new Products('marketzone');
        $productos->delete($id);  // Llamada al método delete
        echo $productos->getData();  // Respuesta del backend
    }

    // Método para editar un producto
    public function editProduct($data) {
        $productos = new Products('marketzone');
        $productos->edit($data);  // Llamada al método edit
        echo $productos->getData();
    }

    // Método para listar todos los productos
    public function listProducts() {
        $productos = new Products('marketzone');
        $productos->list();  // Llamada al método list
        echo $productos->getData();  // Respuesta de la lista de productos
    }

    // Método para buscar productos por nombre
    public function searchProducts($search) {
        $productos = new Products('marketzone');
        $productos->search($search);  // Llamada al método search
        echo $productos->getData();
    }

    // Método para obtener un producto por nombre
    public function getProductByName($name) {
        $productos = new Products('marketzone');
        $productos->getByName($name);  // Llamada al método getByName
        echo $productos->getData();
    }

    // Método para obtener un producto por ID
    public function getProductById($id) {
        $productos = new Products('marketzone');
        $productos->single($id);  // Llamada al método single
        echo $productos->getData();
    }
}
