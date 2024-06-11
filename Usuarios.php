<?php

require_once './db/BaseDatos.php';
require_once './models/usuariosModel.php';

$usuariosModel = new usuariosModel();

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $usuarios = $usuariosModel->obtenerUsuarios();
    echo json_encode($usuarios);
    exit();
}

