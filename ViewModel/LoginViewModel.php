<?php
require_once __DIR__ . '/../Model/AuthModel.php';

class LoginViewModel {
    private $authModel;

    public function __construct() {
        $this->authModel = new AuthModel();
    }

    // Login usando e-mail e senha
    public function handleLogin($email, $senha) {
        if (!$this->isValidEmail($email)) {
            return "E-mail inválido.";
        }

        if (empty($senha)) {
            return "Senha inválida.";
        }

        $user = $this->authModel->loginByEmail($email, $senha);
        
        // Verificar se o usuário foi encontrado e está ativo
        if (!$user) {
            return "Conta inativa ou não encontrada. Entre em contato com o suporte.";
        }

        // Caso o usuário esteja inativo, retorna a mensagem de conta inativa
        if ($user['id_tipo_acesso'] == 3) {
            return "Conta inativa ou não encontrada. Entre em contato com o suporte.";
        }

        // Se o usuário for válido, gera a sessão e faz o redirecionamento
        session_regenerate_id(true);
        $_SESSION['usuario'] = $user;

        switch ($user['id_tipo_acesso']) {
            case 1:
                header("Location: ../adm/");
                exit;
            case 2:
                header("Location: ../licenciado/");
                exit;
            case 3:
                // Destrói a sessão se for id_tipo_acesso 3 e redireciona para login
                session_unset(); 
                session_destroy();
                header("Location: ../login/");
                exit;
        }

        return "Credenciais inválidas."; 
    }
    
    // Login usando CPF e número de garantia
    public function handleGarantia($cpf, $garantia) {
        if (!$this->isValidCPF($cpf)) {
            return "CPF inválido.";
        }
    
        if (!ctype_digit($garantia)) {
            return "Número de garantia inválido.";
        }
    
        $result = $this->authModel->loginByCPFandGarantia($cpf, $garantia);
        if ($result) {
            $result['id_tipo_acesso'] = 3;
            $_SESSION['usuario'] = $result;
            $_SESSION['garantia'] = $result; 
            header("Location: ../consultargarantia/");
            exit;
        }
        return "Garantia ou CPF inválidos.";
    }

    private function isValidEmail($email) {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }

    private function isValidCPF($cpf) {
        $cpf = preg_replace('/\D/', '', $cpf);
        if (strlen($cpf) != 11) {
            return false;
        }

        $invalid_cpfs = [
            '00000000000', '11111111111', '22222222222', '33333333333', '44444444444', 
            '55555555555', '66666666666', '77777777777', '88888888888', '99999999999'
        ];

        if (in_array($cpf, $invalid_cpfs)) {
            return false;
        }

        for ($t = 9; $t < 11; $t++) {
            for ($d = 0, $c = 0; $c < $t; $c++) {
                $d += $cpf[$c] * (($t + 1) - ($c));
            }
            $d = ((10 * $d) % 11) % 10;
            if ($cpf[$t] != $d) {
                return false;
            }
        }

        return true;
    }
} 