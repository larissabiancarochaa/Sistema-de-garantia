<?php
require_once __DIR__ . '/../Model/ListarGarantiaModel.php';

class ListarGarantiaViewModel {
    private $model;

    public function __construct() {
        $this->model = new ListarGarantiaModel();
    }

    public function listarGarantias($filtros) {
        return $this->model->getGarantias($filtros);
    }

    public function excluirGarantia($idGarantia) {
        return $this->model->excluirGarantia($idGarantia);
    }
}