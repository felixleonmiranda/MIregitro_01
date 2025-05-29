<?php
require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public $id;
    public $nombre;
    public $email;
    public $passwordHash;
    public $fecha_registro;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function crear() {
        $query = "INSERT INTO " . $this->table_name . "
                SET nombre = :nombre, email = :email, password_hash = :password_hash";

        $stmt = $this->conn->prepare($query);

        // Limpiar y vincular los datos
        $this->nombre = htmlspecialchars(strip_tags($this->nombre));
        $this->email = htmlspecialchars(strip_tags($this->email));

        $stmt->bindParam(':nombre', $this->nombre);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password_hash', $this->passwordHash);

        try {
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            }
        } catch (PDOException $e) {
            // Error de duplicado de email (código 23000 para violación de UNIQUE)
            if ($e->getCode() == '23000') {
                throw new Exception("Este email ya está registrado.");
            }
            error_log("Error al crear usuario: " . $e->getMessage());
            throw new Exception("Error al registrar el usuario. Por favor, inténtelo de nuevo.");
        }

        return false;
    }

    public function emailExiste() {
        $query = "SELECT id, nombre, password_hash FROM " . $this->table_name . "
                WHERE email = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($query);
        $this->email = htmlspecialchars(strip_tags($this->email));
        $stmt->bindParam(1, $this->email);
        $stmt->execute();

        $num = $stmt->rowCount();

        if ($num > 0) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->id = $row['id'];
            $this->nombre = $row['nombre'];
            $this->passwordHash = $row['password_hash'];
            return true;
        }

        return false;
    }

    public static function hashPassword($password) {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    public function verificarPassword($password) {
        return password_verify($password, $this->passwordHash);
    }
}
?>