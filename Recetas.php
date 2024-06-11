<?php

require_once './db/BaseDatos.php';
require_once './models/recetasModel.php';

$recetasModel = new recetasModel();

header("Content-type: application/json");

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (isset($_GET['idreceta'])) {
        $idreceta = $_GET['idreceta'];
        $receta = $recetasModel->obtenerRecetaPorId($idreceta);
        echo json_encode($receta);
    } else {
        $recetas = $recetasModel->obtenerRecetas();
        echo json_encode($recetas);
    }

    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
    // Obtener los datos del cuerpo de la solicitud
    $post = json_decode(file_get_contents('php://input'), true);
    // Actualizar el pasaje en la base de datos
    $res = $recetasModel->actualizarReceta($post);
    $resul['mensaje'] = $res;
    echo $resul['mensaje'];
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'DELETE') {
    // Obtener el ID del alumno a borrar
    $idreceta = $_GET['id'];
    // Borrar el alumno de la base de datos
    $res = $recetasModel->eliminarReceta($idreceta);
    $resul['mensaje'] = $res;
    echo $resul['mensaje'];
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post = json_decode(file_get_contents('php://input'), true);

    if (isset($post['titulo']) && isset($post['contenido']) && isset($post['categoria']) && isset($post['rol_usuario'])) {
        $res = $recetasModel->insertarReceta($post['titulo'], $post['contenido'], $post['categoria'], $post['rol_usuario']);
        $resul = ['resultado' => $res];
        echo json_encode($resul);
    }

    exit();
}
