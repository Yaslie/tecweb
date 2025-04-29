<?php

require __DIR__ . '/../../vendor/autoload.php';

use Slim\Factory\AppFactory;
use TECWEB\MYAPI\CREATE\Create;
use TECWEB\MYAPI\READ\Read;
use TECWEB\MYAPI\UPDATE\Update;
use TECWEB\MYAPI\DELETE\Delete;

// Crear la aplicación Slim
$app = AppFactory::create();

// Ruta para obtener un producto por ID
$app->get('/product/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $read = new Read('marketzone');
    $read->single($id);
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para obtener todos los productos
$app->get('/products', function ($request, $response) {
    $read = new Read('marketzone');
    $read->list();
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para buscar productos
$app->get('/products/{search}', function ($request, $response, $args) {
    $search = $args['search'];
    $read = new Read('marketzone');
    $read->search($search);
    $response->getBody()->write($read->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para agregar un producto
$app->post('/product', function ($request, $response) {
    $data = $request->getBody()->getContents();
    $create = new Create('marketzone');
    $create->add($data);
    $response->getBody()->write($create->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para editar un producto
$app->put('/product', function ($request, $response) {
    $data = $request->getBody()->getContents();
    $update = new Update('marketzone');
    $update->edit($data);
    $response->getBody()->write($update->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta para eliminar un producto
$app->delete('/product/{id}', function ($request, $response, $args) {
    $id = $args['id'];
    $delete = new Delete('marketzone');
    $delete->delete_dat($id);
    $response->getBody()->write($delete->getData());
    return $response->withHeader('Content-Type', 'application/json');
});

// Ejecutar la aplicación Slim
$app->run();