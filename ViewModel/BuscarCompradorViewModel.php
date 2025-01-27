<?php
require_once __DIR__ . '/../Model/BuscarCompradorModel.php';

class BuscarCompradorViewModel {
    private $model;

    public function __construct() {
        $this->model = new BuscarCompradorModel();
    }

    public function buscarCpf($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf); 
        return $this->model->verificarCpf($cpf);
    }
}