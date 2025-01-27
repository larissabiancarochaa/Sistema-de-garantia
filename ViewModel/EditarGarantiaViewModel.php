<?php
require_once __DIR__ . '/../Model/EditarGarantiaModel.php';
require_once __DIR__ . '/../Utils/PDFGenerator.php';
require_once __DIR__ . '/../Vendor/autoload.php'; // Autoload do composer para carregar dependências

use Utils\PDFGenerator;

class EditarGarantiaViewModel {
    private $model;

    public function __construct() {
        $this->model = new EditarGarantiaModel();
    }

    public function buscarGarantiaPorId($idGarantia) {
        return $this->model->buscarGarantiaPorId($idGarantia);
    }

    public function atualizarGarantia($idGarantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes) {
        $resultado = $this->model->atualizarGarantia($idGarantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes);

        if ($resultado['success']) {
            // Buscar os dados atualizados para incluir no PDF
            $garantia = $this->model->buscarGarantiaPorId($idGarantia);

            // Caminho do diretório para salvar o PDF
            $dir = __DIR__ . "/../Files/GarantiasGeradas/{$garantia['id_garantia']}{$garantia['garantia']}/";

            // Geração do PDF usando PDFGenerator
            PDFGenerator::gerarPDF($garantia, $dir);
        }

        return $resultado;
    }
}