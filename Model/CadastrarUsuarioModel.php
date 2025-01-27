<?php
require_once __DIR__ . '/Database.php';

class UsuarioModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function inserirUsuario($dados, $id_tipo_acesso) {
        try {
            $sql = "INSERT INTO tb_usuarios (nome_completo, email, cpf, rg, telefone, endereco, cep, cidade, estado, data_nascimento, estado_civil) 
                    VALUES (:nome_completo, :email, :cpf, :rg, :telefone, :endereco, :cep, :cidade, :estado, :data_nascimento, :estado_civil)";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute([
                ':nome_completo' => $dados['nome_completo'],
                ':email' => $dados['email'],
                ':cpf' => $dados['cpf'],
                ':rg' => $dados['rg'],
                ':telefone' => $dados['telefone'],
                ':endereco' => $dados['endereco'] ?? null,
                ':cep' => $dados['cep'] ?? null,
                ':cidade' => $dados['cidade'] ?? null,
                ':estado' => $dados['estado'] ?? null,
                ':data_nascimento' => $dados['data_nascimento'] ?? null,
                ':estado_civil' => $dados['estado_civil'] ?? null
            ]);

            $id_usuario = $this->conn->lastInsertId();

            // Insere o login associado ao usuário
            $sqlLogin = "INSERT INTO tb_logins (id_tipo_acesso, id_usuario) VALUES (:id_tipo_acesso, :id_usuario)";
            $stmtLogin = $this->conn->prepare($sqlLogin);
            $stmtLogin->execute([
                ':id_tipo_acesso' => $id_tipo_acesso,
                ':id_usuario' => $id_usuario
            ]);

            return "Usuário cadastrado com sucesso!";
        } catch (PDOException $e) {
            return "Erro ao cadastrar usuário: " . $e->getMessage();
        }
    }
}