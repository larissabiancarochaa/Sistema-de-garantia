<?php
require_once __DIR__ . '/Database.php';

class EditarGarantiaModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function buscarGarantiaPorId($idGarantia) {
        $query = "SELECT g.*, u.* FROM tb_garantias g 
                INNER JOIN tb_usuarios u ON g.id_cliente = u.id_usuario
                WHERE g.id_garantia = :id_garantia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":id_garantia", $idGarantia);
        $stmt->execute();
        $garantia = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($garantia && $garantia['avaliacoes']) {
            $garantia['avaliacoes'] = json_decode($garantia['avaliacoes'], true);
        }
        return $garantia;
    }

    public function atualizarGarantia($idGarantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes) {
        $query = "UPDATE tb_garantias 
                  SET nome_revendedor = :nome_revendedor, data_compra = :data_compra, 
                      data_instalacao = :data_instalacao, modelo_piscina = :modelo_piscina, 
                      avaliacoes = :avaliacoes
                  WHERE id_garantia = :id_garantia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nome_revendedor", $nomeRevendedor);
        $stmt->bindParam(":data_compra", $dataCompra);
        $stmt->bindParam(":data_instalacao", $dataInstalacao);
        $stmt->bindParam(":modelo_piscina", $modeloPiscina);
        $stmt->bindParam(":avaliacoes", $avaliacoes);
        $stmt->bindParam(":id_garantia", $idGarantia);

        try {
            $stmt->execute();
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }
}