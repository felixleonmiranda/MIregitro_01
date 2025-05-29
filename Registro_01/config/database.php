<?php
class Database {
    private $host = '192.168.2.122'; // Cambia esto a la IP de tu servidor MySQL
    private $db_name = 'base_registro';
    private $username = 'root'; // Cambia esto al usuario de tu base de datos
    private $password = 'root'; // Cambia esto a la contraseña de tu base de datos 
    private $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name}", 
                $this->username, 
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8mb4");
        } catch(PDOException $exception) {
            error_log("Error de conexión: " . $exception->getMessage());
            throw new Exception("Error al conectar con la base de datos. Por favor, inténtelo más tarde.");
        }

        return $this->conn;
    }
}
?>