<?php
require_once __DIR__ . '/../Model/Database.php';

class ListarUsuariosModel {

    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection(); // Conexão com o banco
    }

    // Retorna todos os usuários ou um usuário específico
    public function getUsuarios($id = null) {
        if ($id) {
            $query = "SELECT * FROM tb_usuarios WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_usuario', $id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            $query = "SELECT * FROM tb_usuarios";
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }

    // Retorna os usuários filtrados por nome ou CPF
    public function getUsuariosByFilter($filter) {
        $query = "SELECT * FROM tb_usuarios WHERE nome_completo LIKE :filter OR cpf LIKE :filter";
        $stmt = $this->conn->prepare($query);
        $filterParam = "%" . $filter . "%";
        $stmt->bindParam(':filter', $filterParam);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}