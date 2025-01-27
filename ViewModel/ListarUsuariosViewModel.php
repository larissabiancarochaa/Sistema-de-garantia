<?php
require_once __DIR__ . '/../Model/ListarUsuariosModel.php';
require_once __DIR__ . '/../Model/AuthModel.php';

class ListarUsuariosViewModel {
    private $model;
    private $authModel;

    public function __construct() {
        $this->model = new ListarUsuariosModel();
        $this->authModel = new AuthModel();
    }

    // Retorna os dados dos usuários com filtro
    public function getUsuarios($id = null, $filter = null) {
        if ($id) {
            return $this->model->getUsuarios($id);
        }
        
        if ($filter) {
            return $this->model->getUsuariosByFilter($filter);
        }

        return $this->model->getUsuarios();
    }

    // Verifica se o usuário é administrador
    public function isAdmin($idUsuario) {
        $tipoAcesso = $this->authModel->getTipoAcesso($idUsuario);
        return $tipoAcesso == 1; // 1 = Administrador
    }

    // Exclui um usuário
    public function deleteUsuario($id) {
        return $this->model->deleteUsuario($id);
    }
}