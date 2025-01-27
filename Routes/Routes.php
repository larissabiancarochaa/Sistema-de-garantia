<?php
session_start();

// Obtém a URL amigável, removendo barras extras
$requestUri = trim($_SERVER['REQUEST_URI'], '/');

// Se o usuário estiver logado, verifica o tipo de acesso e redireciona para o local correto
if (isset($_SESSION['usuario'])) {
    $usuario = $_SESSION['usuario'];

    // Verificar o tipo de acesso do usuário
    switch ($usuario['id_tipo_acesso']) {
        case 1:
            // Redireciona para o Dashboard de Administrador
            header("Location: ./adm/");
            exit;
        case 2:
            // Redireciona para o Dashboard de Licenciado
            header("Location: ./licenciado/");
            exit;
        case 3:
            // Conta inativa ou não encontrada
            $_SESSION['error_message'] = "Conta inativa ou não encontrada. Por favor, entre em contato com o suporte.";
            header("Location: ./login/");
            exit;
        default:
            // Tipo de acesso inválido
            $_SESSION['error_message'] = "Tipo de acesso inválido.";
            header("Location: ./login/");
            exit;
    }
}

// Roteamento sem sessão para /login e /garantia
switch ($requestUri) {
    case '':
    case 'login':
        header("Location: ./login/");
        break;
    case 'garantia':
        header("Location: ./garantia/");
        break;
    default:
        header("Location: ./login/");
}
exit;