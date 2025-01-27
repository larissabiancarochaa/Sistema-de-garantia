<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo_acesso'] == 3) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/CadastrarGarantiaViewModel.php';

$viewModel = new CadastrarGarantiaViewModel();
$mensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'] ?? '';
    $usuario = $viewModel->verificarCpf($cpf);

    if ($usuario) {
        $idCliente = $usuario['id_usuario'];
        $garantia = $_POST['garantia'] ?? '';
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

        $idUsuarioCadastro = $_SESSION['usuario']['id_usuario'];

        $resultado = $viewModel->cadastrarGarantia($idCliente, $garantia, $nomeRevendedor, $dataCompra, $dataInstalacao, $modeloPiscina, $avaliacoes, $idUsuarioCadastro);
        if ($resultado['success']) {
            $mensagem = "Garantia cadastrada com sucesso!";
        } else {
            $mensagem = $resultado['error'];
        }
    } else {
        $mensagem = "CPF não encontrado. Cadastre o usuário antes de continuar.";
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
    <h2>Cadastrar Garantia</h2>

    <?php if ($mensagem): ?>
        <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label for="cpf">CPF:</label>
        <input type="text" id="cpf" name="cpf" required maxlength="14">
        
        <label for="garantia">Número de Garantia:</label>
        <input type="text" id="garantia" name="garantia" required>

        <label for="nome_revendedor">Nome do Revendedor:</label>
        <input type="text" id="nome_revendedor" name="nome_revendedor" required>

        <label for="data_compra">Data da Compra:</label>
        <input type="date" id="data_compra" name="data_compra" required>

        <label for="data_instalacao">Data da Instalação:</label>
        <input type="date" id="data_instalacao" name="data_instalacao" required>

        <label for="modelo_piscina">Modelo da Piscina:</label>
        <input type="text" id="modelo_piscina" name="modelo_piscina" required>

        <label for="atendimento">Como foi o atendimento do revendedor?</label>
        <select id="atendimento" name="atendimento" required>
            <option value="Ótimo">Ótimo</option>
            <option value="Bom">Bom</option>
            <option value="Regular">Regular</option>
            <option value="Péssimo">Péssimo</option>
        </select>

        <label for="produto">Como você está avaliando nosso produto?</label>
        <select id="produto" name="produto" required>
            <option value="Ótimo">Ótimo</option>
            <option value="Bom">Bom</option>
            <option value="Regular">Regular</option>
            <option value="Péssimo">Péssimo</option>
        </select>

        <label for="motivo">Por que você optou por um produto Original Piscinas?</label>
        <select id="motivo" name="motivo" required>
            <option value="Preço">Preço</option>
            <option value="Indicação">Indicação</option>
            <option value="Atendimento">Atendimento</option>
            <option value="Qualidade">Qualidade</option>
        </select>

        <label for="origem">Como você conheceu a Original Piscinas?</label>
        <select id="origem" name="origem" onchange="toggleOutros(this.value)" required>
            <option value="Indicação de amigo">Indicação de amigo</option>
            <option value="Redes Sociais">Redes Sociais</option>
            <option value="Revenda">Revenda</option>
            <option value="Google">Google</option>
            <option value="TV">TV</option>
            <option value="Catálogo">Catálogo</option>
            <option value="Outros">Outros</option>
        </select>

        <div id="outros-container" style="display: none;">
            <label for="outros">Especifique:</label>
            <input type="text" id="outros" name="outros">
        </div>

        <button type="submit">Cadastrar Garantia</button>
    </form>

    <a href="./../">Voltar</a>
</body>
</html>