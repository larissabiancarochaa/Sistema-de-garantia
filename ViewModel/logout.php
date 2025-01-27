<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['usuario'])) {
    // Verifica o tipo de acesso antes de destruir a sessão
    $id_tipo_acesso = $_SESSION['usuario']['id_tipo_acesso'];
    
    // Destroi a sessão
    session_unset();
    session_destroy();

    // Redireciona dependendo do tipo de usuário
    if ($id_tipo_acesso == 3) {
        header("Location: ../garantia/");
    } else {
        header("Location: ../login/");
    }
    exit;
}

// Caso o usuário não esteja logado, redireciona para a página de login
header("Location: ../login/");
exit;