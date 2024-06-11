<?php

require_once './db/BaseDatos.php';

class categoriasModel extends Basedatos {

    private $db;
    private $table;

    public function __construct() {
        $this->db = new Basedatos();
        $this->table = "categorias";
    }

    /**
     * Obtiene todas las categorías desde la base de datos.
     *
     * @return array|null Arreglo asociativo con las categorías o null si no hay categorías.
     */
    public function obtenerTodasLasCategorias() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->getConexion()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
