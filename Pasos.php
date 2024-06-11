<?php

require_once './db/BaseDatos.php';
require_once './models/pasosModel.php';

$pasosModel=new pasosModel();

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $pasos=$pasosModel->obtenerTodosLosPasos();
    echo json_encode($pasos);
    exit();
}
