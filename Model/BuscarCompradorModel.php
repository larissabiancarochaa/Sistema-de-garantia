<?php
require_once __DIR__ . '/Database.php';

class BuscarCompradorModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function verificarCpf($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf); 
        $query = "SELECT * FROM tb_usuarios WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}