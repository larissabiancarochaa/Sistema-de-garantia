<?php

require_once __DIR__ . '/../Model/BuscarGarantiaModel.php';

class BuscarGarantiaViewModel
{
    private $model;

    public function __construct()
    {
        $this->model = new BuscarGarantiaModel();
    }

    public function buscarGarantias($cpf, $numeroGarantia = null)
    {
        if (empty($cpf)) {
            return ['success' => false, 'message' => 'O CPF é obrigatório para a busca.'];
        }

        $resultado = $this->model->buscarPorCpfOuGarantia($cpf, $numeroGarantia);

        if (empty($resultado)) {
            return ['success' => false, 'message' => 'Nenhuma garantia encontrada para os critérios informados.'];
        }

        return ['success' => true, 'data' => $resultado];
    }
}