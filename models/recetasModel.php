<?php

require_once './db/BaseDatos.php';

class recetasModel extends Basedatos {

    private $db;
    private $table;

    public function __construct() {
        $this->db = new Basedatos();
        $this->table = "recetas";
    }

    public function obtenerRecetas() {
        $query = "SELECT * FROM $this->table";
        $stmt = $this->db->getConexion()->prepare($query);
        $stmt->execute();
        $recetas = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($recetas as &$receta) {
            if (isset($receta['foto'])) {
                $receta['foto'] = base64_encode($receta['foto']);
            }
        }
        return $recetas;
    }

    public function obtenerRecetaPorId($idreceta) {
        $query = "SELECT * FROM $this->table WHERE id = :idreceta";
        $stmt = $this->db->getConexion()->prepare($query);
        $stmt->bindParam(':idreceta', $idreceta, PDO::PARAM_INT);
        $stmt->execute();
        $receta = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($receta && isset($receta['foto'])) {
            $receta['foto'] = base64_encode($receta['foto']);
        }

        return $receta;
    }

    public function actualizarReceta($idreceta) {
        $conexion = $this->db->getConexion();

        $query = "UPDATE $this->table SET titulo = ?, contenido = ?, id_categoria = ? WHERE id = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$idreceta['titulo'], $idreceta['contenido'], $idreceta['categoria'], $idreceta['id_receta']]);

        if ($stmt->rowCount() > 0) {
            return "<h2>RECETA ACTUALIZADA CORRECTAMENTE</h2>";
        } else {
            return "<h2>ERROR AL ACTUALIZAR LA RECETA</h2>";
        }
    }

    public function eliminarReceta($id_receta) {
        try {
            // Eliminar los comentarios asociados a la receta
            $queryComentarios = "DELETE FROM comentarios WHERE id_receta = :id";
            $stmtComentarios = $this->db->getConexion()->prepare($queryComentarios);
            $stmtComentarios->bindParam(':id', $id_receta, PDO::PARAM_INT);
            $stmtComentarios->execute();

            // Eliminar los pasos asociados a la receta
            $queryPasos = "DELETE FROM pasos WHERE id_receta = :id";
            $stmtPasos = $this->db->getConexion()->prepare($queryPasos);
            $stmtPasos->bindParam(':id', $id_receta, PDO::PARAM_INT);
            $stmtPasos->execute();

            // Eliminar los ingredientes asociados a la receta
            $queryIngredientes = "DELETE FROM ingredientes WHERE id_receta = :id";
            $stmtIngredientes = $this->db->getConexion()->prepare($queryIngredientes);
            $stmtIngredientes->bindParam(':id', $id_receta, PDO::PARAM_INT);
            $stmtIngredientes->execute();

            // Finalmente, eliminar la receta de la tabla 'recetas'
            $queryReceta = "DELETE FROM recetas WHERE id = :id";
            $stmtReceta = $this->db->getConexion()->prepare($queryReceta);
            $stmtReceta->bindParam(':id', $id_receta, PDO::PARAM_INT);
            $stmtReceta->execute();

            if ($stmtReceta->rowCount() > 0) {
                return "<h2>RECETA ELIMINADA</h2>";
            } else {
                return "<h2>ERROR AL ELIMINAR</h2>";
            }
        } catch (PDOException $e) {
            return "<h2>ERROR: No se ha podido eliminar la receta</h2>";
        }
    }

    public function insertarReceta($titulo, $contenido, $categoria, $rolusuario) {
        try {
            $query = "SELECT COUNT(*) FROM $this->table WHERE titulo = ?";
            $stmt = $this->db->getConexion()->prepare($query);
            $stmt->bindParam(1, $titulo);
            $stmt->execute();
            $rowCount = $stmt->fetchColumn();

            if ($rowCount > 0) {
                return "<h2>ERROR: La receta ya está registrada</h2>";
            }

            $query = "INSERT INTO recetas (titulo, contenido, id_categoria, id_usuario) VALUES (?, ?, ?, ?)";
            $stmt = $this->db->getConexion()->prepare($query);
            $stmt->bindParam(1, $titulo);
            $stmt->bindParam(2, $contenido);
            $stmt->bindParam(3, $categoria);
            $stmt->bindParam(4, $rolusuario);

            if ($stmt->execute()) {
                return "<h2>RECETA INSERTADA CORRECTAMENTE</h2>";
            } else {
                return "<h2>ERROR: No se ha podido insertar la receta</h2>";
            }
        } catch (PDOException $e) {
            return "<h2>ERROR: No se ha podido insertar la receta</h2>";
        }
    }
}
