<?php
use TECWEB\CONTROLLER\ProductController;

// Inicializamos el controlador
$controller = new ProductController();

// Verificamos el tipo de solicitud (POST o GET)
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Agregar o editar producto
    if (isset($_POST['action']) && $_POST['action'] == 'add') {
        $controller->addProduct($_POST);  // Llamada al controlador para agregar producto
    } else if (isset($_POST['action']) && $_POST['action'] == 'edit') {
        $controller->editProduct($_POST);  // Llamada para editar producto
    }
} else if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // Listar productos o buscar productos por nombre
    if (isset($_GET['action']) && $_GET['action'] == 'list') {
        $controller->listProducts();  // Llamada para listar productos
    } else if (isset($_GET['search'])) {
        $controller->searchProducts($_GET['search']);  // Llamada para buscar productos
    } else if (isset($_GET['id'])) {
        $controller->getProductById($_GET['id']);  // Llamada para obtener un producto por ID
    }
}
