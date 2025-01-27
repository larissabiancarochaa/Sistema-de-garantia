<?php
require_once __DIR__ . '/Database.php';

class AuthModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    // Login com email e CPF (tratando CPF como senha)
    public function loginByEmail($email, $cpf) {
        $query = "SELECT u.*, l.id_tipo_acesso FROM tb_usuarios u
                  INNER JOIN tb_logins l ON u.id_usuario = l.id_usuario
                  WHERE u.email = :email AND u.cpf = :cpf"; 
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":email", $email);
        $stmt->bindParam(":cpf", $cpf);  
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);  
    }

    // Login com CPF e número de garantia
    public function loginByCPFandGarantia($cpf, $garantia) {
        $cpf = preg_replace('/\D/', '', $cpf); 
        $query = "SELECT * FROM tb_garantias g
                  INNER JOIN tb_usuarios u ON g.id_cliente = u.id_usuario
                  WHERE u.cpf = :cpf AND g.garantia = :garantia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":cpf", $cpf);
        $stmt->bindParam(":garantia", $garantia);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // Verifica o tipo de acesso do usuário logado
    public function getTipoAcesso($idUsuario) {
        $query = "SELECT l.id_tipo_acesso FROM tb_logins l 
                WHERE l.id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $idUsuario);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result ? $result['id_tipo_acesso'] : null;
    }
}