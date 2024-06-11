<?php

require_once './db/BaseDatos.php';

class usuariosModel extends Basedatos {

    private $db;
    private $table;

    public function __construct() {
        $this->db = new Basedatos();
        $this->table = "usuarios";
    }

    public function obtenerUsuarios() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->getConexion()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
