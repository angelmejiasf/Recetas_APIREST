<?php

/**
 * Clase BaseDatos para gestionar la conexión a la base de datos.
 */
class Basedatos {

    private $conexion;
    private $mensajeerror = "";

    /**
     * Establece la conexión a la base de datos.
     *
     * @return PDO|null Objeto de conexión PDO si la conexión es exitosa, o null si hay un error.
     */
    public function getConexion() {
        include './config/config.php';
        try {
            $this->conexion = new PDO("mysql:host=$servername;dbname=$database;charset=utf8",
                    $username, $password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            $this->mensajeerror = $e->getMessage();
        }
    }

    /**
     * Cierra la conexión a la base de datos.
     *
     * @return void
     */
    public function closeConexion() {
        $this->conexion = null;
    }

    /**
     * Devuelve el mensaje de error, si lo hay.
     *
     * @return string Mensaje de error.
     */
    public function getMensajeError() {
        return $this->mensajeerror;
    }
}
