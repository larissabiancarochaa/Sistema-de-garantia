<?php

require_once __DIR__ . '/Database.php';

class BuscarGarantiaModel
{
    private $db;

    public function __construct()
    {
        // Chama o método correto para obter a conexão com o banco
        $this->db = Database::getConnection();
    }

    public function buscarPorCpfOuGarantia($cpf, $numeroGarantia = null)
    {
        // Corrigir o nome da tabela para tb_garantias
        $query = "SELECT * FROM tb_garantias WHERE id_cliente = (SELECT id_usuario FROM tb_usuarios WHERE cpf = :cpf)";
        $params = ['cpf' => $cpf];

        if (!empty($numeroGarantia)) {
            $query .= " AND garantia = :numeroGarantia";
            $params['numeroGarantia'] = $numeroGarantia;
        }

        $stmt = $this->db->prepare($query);
        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
