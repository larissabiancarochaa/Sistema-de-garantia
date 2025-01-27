<?php
require_once __DIR__ . '/../Model/CadastrarGarantiaModel.php';

class CadastrarGarantiaViewModel {
    private $model;

    public function __construct() {
        $this->model = new CadastrarGarantiaModel();
    }

    public function verificarCpf($cpf) {
        return $this->model->buscarUsuarioPorCpf($cpf);
    }

    public function cadastrarGarantia($idCliente, $garantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes, $idUsuarioCadastro) {
        return $this->model->cadastrarGarantia($idCliente, $garantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes, $idUsuarioCadastro);
    }
}