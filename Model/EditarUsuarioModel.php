<?php
require_once __DIR__ . '/Database.php';

class EditarUsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function buscarUsuarioPorId($idUsuario) {
        $query = "SELECT * FROM tb_usuarios WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_usuario", $idUsuario, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizarUsuario($dados) {
        $query = "UPDATE tb_usuarios SET 
                    nome_completo = :nome_completo,
                    email = :email,
                    cpf = :cpf,
                    rg = :rg,
                    telefone = :telefone,
                    endereco = :endereco,
                    cep = :cep,
                    cidade = :cidade,
                    estado = :estado,
                    data_nascimento = :data_nascimento,
                    estado_civil = :estado_civil
                  WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        foreach ($dados as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        return $stmt->execute();
    }
}