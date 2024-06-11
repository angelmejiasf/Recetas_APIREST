<?php

require_once './db/BaseDatos.php';
require_once './models/categoriasModel.php';

$categoriasModel = new categoriasModel();

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $categorias = $categoriasModel->obtenerTodasLasCategorias();
    echo json_encode($categorias);
    exit();
}
