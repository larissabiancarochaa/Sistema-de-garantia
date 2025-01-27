<?php
// Impede que a página seja armazenada no cache
header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
header('Pragma: no-cache');
header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');

session_start();

require_once __DIR__ . '/../ViewModel/LoginViewModel.php';

$loginViewModel = new LoginViewModel();

// Protege a página contra acessos não autorizados
if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['id_tipo_acesso'], [1, 2, 3])) {
    header("Location: ./login");
    exit;
}

// Captura o nome e o tipo de acesso do usuário logado
$nome_usuario = $_SESSION['usuario']['nome_completo'] ?? 'Usuário';
$id_tipo_acesso = $_SESSION['usuario']['id_tipo_acesso'];

// Define a mensagem de boas-vindas com base no tipo de acesso
switch ($id_tipo_acesso) {
    case 1:
        $mensagem = "Bem-vindo, $nome_usuario! Você tem acesso ao painel de Administrador.";
        break;
    case 2:
        $mensagem = "Bem-vindo, $nome_usuario! Você tem acesso ao painel de Usuário Licenciado.";
        break;
    case 3:
        $mensagem = "Bem-vindo, $nome_usuario! Sua conta está inativa ou você é um Cliente final.";
        break;
    default:
        $mensagem = "Bem-vindo, $nome_usuario!";
}

if (isset($_SESSION['garantia'])) {
    $id_garantia = $_SESSION['garantia']['id_garantia'] ?? 'N/A';
    $garantia = $_SESSION['garantia']['garantia'] ?? 'N/A';
    $revendedor = $_SESSION['garantia']['nome_revendedor'] ?? 'N/A';
    $revendedor = $_SESSION['garantia']['nome_revendedor'] ?? 'N/A';
    $data_compra = $_SESSION['garantia']['data_compra'] ?? 'N/A';
    $modelo_piscina = $_SESSION['garantia']['modelo_piscina'] ?? 'N/A';
} else {
    $revendedor = $data_compra = $modelo_piscina = 'Informações não encontradas';
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            justify-content: space-between;
        }

        header {
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
            text-align: center;
        }

        header h2 {
            margin-bottom: 0.5rem;
        }

        header a {
            color: #fff;
            text-decoration: none;
            font-weight: bold;
            margin-top: 0.5rem;
            display: inline-block;
        }

        header a:hover {
            text-decoration: underline;
        }

        main {
            padding: 1rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            justify-content: center;
        }

        .card {
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 1rem;
            text-align: center;
            width: 280px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .card a {
            text-decoration: none;
            color: #007bff;
            font-weight: bold;
        }

        .card a:hover {
            text-decoration: underline;
        }

        h3 {
            margin-top: 2rem;
            color: #0056b3;
            text-align: center;
        }

        footer {
            text-align: center;
            background-color: #007bff;
            color: #fff;
            padding: 1rem;
            margin-top: 2rem;
            font-size: 0.875rem;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            main {
                flex-direction: column;
                align-items: center;
            }

            .card {
                width: 90%;
            }
        }
    </style>
</head>
<body>

<header>
    <h2><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></h2>
    <a href="../ViewModel/logout.php">Sair</a>
</header>

<main>
    <?php if ($id_tipo_acesso == 1): ?>
        <div class="card">
            <a href="../cadastrarusuario/">Cadastrar Usuário</a>
        </div>
        <div class="card">
            <a href="../listarusuarios/">Listar Usuários</a> 
        </div>
        <div class="card">
            <a href="../cadastrargarantia/">Cadastrar Garantia</a>
        </div>
        <div class="card">
            <a href="../listargarantias/">Listar Garantias</a>
        </div>
    <?php elseif ($id_tipo_acesso == 2): ?>
        <div class="card">
            <a href="../cadastrarusuario/">Cadastrar Comprador</a>
        </div>
        <div class="card">
            <a href="../buscarusuario/">Buscar Comprador</a>
        </div>
        <div class="card">
            <a href="../cadastrargarantia/">Cadastrar Garantia</a>
        </div>
        <div class="card">
            <a href="../buscargarantia/">Buscar Garantia</a>
        </div>
    <?php elseif ($id_tipo_acesso == 3): ?>
        <div class="card">
            <a download href="<?= 
                    '../pdfgarantia/' .
                    $id_garantia .
                    $garantia .
                    '/garantia_original_piscinas_' .
                    $garantia .
                    '.pdf' ?>"
            >
                Baixar Garantia
            </a>
        </div>
        <div class="card">
            <a target="_black" href="<?= 
                    '../pdfgarantia/' .
                    $id_garantia .
                    $garantia .
                    '/garantia_original_piscinas_' .
                    $garantia .
                    '.pdf' ?>"
            >
                Visualizar Garantia
            </a>
        </div>
    <?php endif; ?>
</main>

<footer>
    <p>Feito por Perfomax</p>
</footer>

</body>
</html>
