<?php
require_once __DIR__ . '/../Model/EditarUsuarioModel.php';

class EditarUsuarioViewModel {
    private $model;

    public function __construct() {
        $this->model = new EditarUsuarioModel();
    }

    public function getUsuario($idUsuario) {
        return $this->model->buscarUsuarioPorId($idUsuario);
    }

    public function atualizarUsuario($dados) {
        return $this->model->atualizarUsuario($dados);
    }
}