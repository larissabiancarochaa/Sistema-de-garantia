<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo_acesso'] == 3) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/EditarGarantiaViewModel.php';

$viewModel = new EditarGarantiaViewModel();
$mensagem = null;
$garantia = null;

// Verifica se o ID da garantia foi enviado via GET
$idGarantia = $_GET['id_garantia'] ?? null;

if (!$idGarantia) {
    die("ID da garantia não fornecido.");
}

// Carrega os dados da garantia para edição
$garantia = $viewModel->buscarGarantiaPorId($idGarantia);

if (!$garantia) {
    die("Garantia não encontrada.");
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nomeRevendedor = $_POST['nome_revendedor'] ?? '';
    $dataCompra = $_POST['data_compra'] ?? '';
    $dataInstalacao = $_POST['data_instalacao'] ?? '';
    $modeloPiscina = $_POST['modelo_piscina'] ?? '';
    $avaliacoes = json_encode([
        'atendimento' => $_POST['atendimento'] ?? '',
        'produto' => $_POST['produto'] ?? '',
        'motivo' => $_POST['motivo'] ?? '',
        'origem' => $_POST['origem'] ?? '',
        'outros' => $_POST['outros'] ?? ''
    ]);

    $resultado = $viewModel->atualizarGarantia($idGarantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes);
    if ($resultado['success']) {
        $mensagem = "Garantia atualizada com sucesso!";
        // Atualiza os dados carregados
        $garantia = $viewModel->buscarGarantiaPorId($idGarantia);
    } else {
        $mensagem = $resultado['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Garantia</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            color: #0056b3;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"], 
        input[type="date"], 
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type="text"]:focus, 
        input[type="date"]:focus, 
        select:focus {
            border-color: #0056b3;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 86, 179, 0.3);
        }

        button {
            width: 100%;
            padding: 10px;
            background: #0056b3;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background: #0041a8;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            color: #0056b3;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }

        p {
            text-align: center;
            padding: 10px;
            color: green;
            font-weight: bold;
        }

        #outros-container {
            margin-bottom: 15px;
        }

        @media (max-width: 768px) {
            form {
                padding: 15px;
            }

            button {
                font-size: 14px;
                padding: 8px;
            }
        }

        @media (max-width: 480px) {
            h2 {
                font-size: 20px;
            }

            button {
                font-size: 12px;
                padding: 6px;
            }
        }
    </style>
    
    <script>
    function toggleOutros(opcao) {
        const outrosInput = document.getElementById('outros-container');
        if (opcao === 'Outros') {
            outrosInput.style.display = 'block';
        } else {
            outrosInput.style.display = 'none';
            document.getElementById('outros').value = '';
        }
    }
    </script>
</head>
<body>
    <h2>Editar Garantia</h2>

    <?php if ($mensagem): ?>
        <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="cpf">CPF do Cliente:</label>
        <input type="text" id="cpf" name="cpf" value="<?= htmlspecialchars($garantia['cpf'], ENT_QUOTES, 'UTF-8'); ?>" disabled>

        <label for="garantia">Número de Garantia:</label>
        <input type="text" id="garantia" name="garantia" value="<?= htmlspecialchars($garantia['garantia'], ENT_QUOTES, 'UTF-8'); ?>" disabled>

        <label for="nome_revendedor">Nome do Revendedor:</label>
        <input type="text" id="nome_revendedor" name="nome_revendedor" value="<?= htmlspecialchars($garantia['nome_revendedor'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="data_compra">Data da Compra:</label>
        <input type="date" id="data_compra" name="data_compra" value="<?= htmlspecialchars($garantia['data_compra'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="data_instalacao">Data da Instalação:</label>
        <input type="date" id="data_instalacao" name="data_instalacao" value="<?= htmlspecialchars($garantia['data_instalacao'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="modelo_piscina">Modelo da Piscina:</label>
        <input type="text" id="modelo_piscina" name="modelo_piscina" value="<?= htmlspecialchars($garantia['modelo_piscina'], ENT_QUOTES, 'UTF-8'); ?>" required>

        <label for="atendimento">Como foi o atendimento do revendedor?</label>
        <select id="atendimento" name="atendimento" required>
            <option value="Ótimo" <?= $garantia['avaliacoes']['atendimento'] === 'Ótimo' ? 'selected' : ''; ?>>Ótimo</option>
            <option value="Bom" <?= $garantia['avaliacoes']['atendimento'] === 'Bom' ? 'selected' : ''; ?>>Bom</option>
            <option value="Regular" <?= $garantia['avaliacoes']['atendimento'] === 'Regular' ? 'selected' : ''; ?>>Regular</option>
            <option value="Péssimo" <?= $garantia['avaliacoes']['atendimento'] === 'Péssimo' ? 'selected' : ''; ?>>Péssimo</option>
        </select>

        <label for="produto">Como você está avaliando nosso produto?</label>
        <select id="produto" name="produto" required>
            <option value="Ótimo" <?= $garantia['avaliacoes']['produto'] === 'Ótimo' ? 'selected' : ''; ?>>Ótimo</option>
            <option value="Bom" <?= $garantia['avaliacoes']['produto'] === 'Bom' ? 'selected' : ''; ?>>Bom</option>
            <option value="Regular" <?= $garantia['avaliacoes']['produto'] === 'Regular' ? 'selected' : ''; ?>>Regular</option>
            <option value="Péssimo" <?= $garantia['avaliacoes']['produto'] === 'Péssimo' ? 'selected' : ''; ?>>Péssimo</option>
        </select>

       <label for="origem">Como você conheceu a Original Piscinas?</label>
        <select id="origem" name="origem" onchange="toggleOutros(this.value)" required>
            <option value="Indicação de amigo" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Indicação de amigo' ? 'selected' : ''; ?>>Indicação de amigo</option>
            <option value="Redes Sociais" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Redes Sociais' ? 'selected' : ''; ?>>Redes Sociais</option>
            <option value="Revenda" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Revenda' ? 'selected' : ''; ?>>Revenda</option>
            <option value="Google" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Google' ? 'selected' : ''; ?>>Google</option>
            <option value="TV" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'TV' ? 'selected' : ''; ?>>TV</option>
            <option value="Catálogo" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Catálogo' ? 'selected' : ''; ?>>Catálogo</option>
            <option value="Outros" <?= isset($garantia['avaliacoes']['origem']) && $garantia['avaliacoes']['origem'] === 'Outros' ? 'selected' : ''; ?>>Outros</option>
        </select>

        <div id="outros-container" style="display: <?= $garantia['avaliacoes']['origem'] === 'Outros' ? 'block' : 'none'; ?>;">
            <label for="outros">Especifique:</label>
            <input type="text" id="outros" name="outros" value="<?= htmlspecialchars($garantia['avaliacoes']['outros'], ENT_QUOTES, 'UTF-8'); ?>">
        </div>

        <button type="submit">Atualizar Garantia</button>
    </form>

    <a href="./../">Voltar</a>
</body>
</html>