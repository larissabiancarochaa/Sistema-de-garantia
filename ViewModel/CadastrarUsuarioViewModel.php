<?php
require_once __DIR__ . '/../Model/CadastrarUsuarioModel.php';

class CadastrarUsuarioViewModel {
    private $usuarioModel;

    public function __construct() {
        $this->usuarioModel = new UsuarioModel();
        
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function validarCpf($cpf) {
        $cpf = preg_replace('/[^0-9]/', '', $cpf);
        
        if (strlen($cpf) != 11 || preg_match('/^(\\d)\\1{10}$/', $cpf) || preg_match('/^(12|21|23|32|34|43|45|54|56|65|67|76|78|87|89|98){5}$/', $cpf)) {
            return false;
        }
        
        for ($t = 9; $t < 11; $t++) {
            $d = 0;
            for ($c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - $c);
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$c] != $d) {
                return false;
            }
        }
        return true;
    }

    public function validarRg($rg) {
        return preg_match('/^[0-9]{7,10}$/', $rg);
    }
 
    public function validarIdade($dataNascimento) {
        $dataNascimento = DateTime::createFromFormat('Y-m-d', $dataNascimento);
        
        if (!$dataNascimento) {
            return false;
        }

        $hoje = new DateTime();
        $idade = $hoje->diff($dataNascimento)->y;

        return $idade >= 18;
    }

    public function cadastrarUsuario($dados) {
        if (!isset($_SESSION['usuario'])) {
            return "Erro: Sessão inválida.";
        }

        if (!$this->validarCpf($dados['cpf'])) {
            return "Erro: CPF inválido.";
        }

        if (!$this->validarRg($dados['rg'])) {
            return "Erro: RG inválido.";
        }

        if (!$this->validarIdade($dados['data_nascimento'])) {
            return "Erro: Você precisa ter pelo menos 18 anos para se cadastrar.";
        }

        $dados['endereco'] = trim($dados['bairro'] . ', ' . $dados['endereco'] . ', ' . $dados['numero']);

        $id_tipo_acesso_logado = $_SESSION['usuario']['id_tipo_acesso'];

        if ($id_tipo_acesso_logado == 1) {
            $id_tipo_acesso = isset($dados['id_tipo_acesso']) ? (int)$dados['id_tipo_acesso'] : 3;
        } elseif ($id_tipo_acesso_logado == 2) {
            $id_tipo_acesso = 3;
        } else {
            return "Erro: Você não tem permissão para cadastrar usuários.";
        }

        return $this->usuarioModel->inserirUsuario($dados, $id_tipo_acesso);
    }
}