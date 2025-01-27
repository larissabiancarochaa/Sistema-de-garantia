<?php
require_once __DIR__ . '/Database.php';
require_once __DIR__ . '/../Vendor/autoload.php'; 
require_once __DIR__ . '/../Utils/PDFGenerator.php';

use Utils\PDFGenerator;

class CadastrarGarantiaModel {
    private $conn;

    public function __construct() {
        $this->conn = Database::getConnection();
    }

    public function buscarUsuarioPorCpf($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf);
        $query = "SELECT id_usuario FROM tb_usuarios WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cadastrarGarantia($idCliente, $garantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes, $idUsuarioCadastro) {
        try {
            $query = "INSERT INTO tb_garantias (id_cliente, garantia, nome_revendedor, data_compra, data_instalacao, modelo_piscina, avaliacoes, id_usuario_cadastro)
                      VALUES (:id_cliente, :garantia, :nome_revendedor, :data_compra, :data_instalacao, :modelo_piscina, :avaliacoes, :id_usuario_cadastro)";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id_cliente', $idCliente);
            $stmt->bindParam(':garantia', $garantia);
            $stmt->bindParam(':nome_revendedor', $nomeRevendedor);
            $stmt->bindParam(':data_compra', $dataCompra);
            $stmt->bindParam(':data_instalacao', $dataInstalacao);
            $stmt->bindParam(':modelo_piscina', $modeloPiscina);
            $stmt->bindParam(':avaliacoes', $avaliacoes);
            $stmt->bindParam(':id_usuario_cadastro', $idUsuarioCadastro);
            $stmt->execute();

            $garantiaData = $this->buscarGarantiaPorId($garantia);
            
            $dir = __DIR__ . "/../Files/GarantiasGeradas/{$garantiaData['id_garantia']}{$garantiaData['garantia']}/";
            PDFGenerator::gerarPDF($garantiaData, $dir);

            return ['success' => true];
        } catch (PDOException $e) {
            if ($e->getCode() === '23000') {
                return ['success' => false, 'error' => 'O número de garantia já está cadastrado.'];
            }
            return ['success' => false, 'error' => 'Erro ao cadastrar garantia: ' . $e->getMessage()];
        }
    }

    private function buscarGarantiaPorId($garantia) {
        $query = "SELECT g.*, u.* FROM tb_garantias g 
                  INNER JOIN tb_usuarios u ON g.id_cliente = u.id_usuario
                  WHERE g.garantia = :garantia";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":garantia", $garantia);
        $stmt->execute();
        $garantiaData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($garantiaData && $garantiaData['avaliacoes']) {
            $garantiaData['avaliacoes'] = json_decode($garantiaData['avaliacoes'], true);
        }

        return $garantiaData;
    }
}