<?php
session_start();

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['id_tipo_acesso'], [1, 2])) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/EditarUsuarioViewModel.php';

$idUsuario = $_GET['id'] ?? null;
$viewModel = new EditarUsuarioViewModel();

if (!$idUsuario) {
    echo "Usuário não encontrado!";
    exit;
}

$usuario = $viewModel->getUsuario($idUsuario);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $dados = [
        'id_usuario' => $idUsuario,
        'nome_completo' => $_POST['nome_completo'],
        'email' => $_POST['email'],
        'cpf' => $_POST['cpf'],
        'rg' => $_POST['rg'],
        'telefone' => $_POST['telefone'],
        'endereco' => $_POST['endereco'],
        'cep' => $_POST['cep'],
        'cidade' => $_POST['cidade'],
        'estado' => $_POST['estado'],
        'data_nascimento' => $_POST['data_nascimento'],
        'estado_civil' => $_POST['estado_civil']
    ];

    $sucesso = $viewModel->atualizarUsuario($dados);
    $mensagem = $sucesso ? "Usuário atualizado com sucesso!" : "Erro ao atualizar usuário.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuário</title>

     <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            display: flex;
            flex-direction: column;
        }

        label {
            display: block;
            font-size: 14px;
            font-weight: bold;
            margin-bottom: 5px;
            color: #555;
        }

        input[type="text"], input[type="email"], input[type="date"], select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 14px;
        }

        button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
            width: 100%;
        }

        button:hover {
            background-color: #0056b3;
        }

        a {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-size: 14px;
            color: #007BFF;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        a:hover {
            color: #0056b3;
        }

        p {
            color: #d9534f;
            font-size: 14px;
            text-align: center;
            margin-bottom: 20px;
        }
    </style>

</head>
<body>

<h2>Editar Usuário</h2>

<?php if (isset($mensagem)): ?>
    <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST">
    <label>Nome Completo:</label>
    <input type="text" name="nome_completo" value="<?= htmlspecialchars($usuario['nome_completo'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Email:</label>
    <input type="email" name="email" value="<?= htmlspecialchars($usuario['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>CPF:</label>
    <input type="text" name="cpf" value="<?= htmlspecialchars($usuario['cpf'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>RG:</label>
    <input type="text" name="rg" value="<?= htmlspecialchars($usuario['rg'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Telefone:</label>
    <input type="text" name="telefone" value="<?= htmlspecialchars($usuario['telefone'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>CEP:</label>
    <input type="text" name="cep" value="<?= htmlspecialchars($usuario['cep'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Endereço:</label>
    <input type="text" name="endereco" value="<?= htmlspecialchars($usuario['endereco'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Cidade:</label>
    <input type="text" name="cidade" value="<?= htmlspecialchars($usuario['cidade'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Estado:</label>
    <input type="text" name="estado" value="<?= htmlspecialchars($usuario['estado'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Data de Nascimento:</label>
    <input type="date" name="data_nascimento" value="<?= htmlspecialchars($usuario['data_nascimento'] ?? '', ENT_QUOTES, 'UTF-8'); ?>" required><br>

    <label>Estado Civil:</label>
    <select name="estado_civil">
        <option value="Solteiro" <?= ($usuario['estado_civil'] ?? '') === 'Solteiro' ? 'selected' : ''; ?>>Solteiro</option>
        <option value="Casado" <?= ($usuario['estado_civil'] ?? '') === 'Casado' ? 'selected' : ''; ?>>Casado</option>
        <option value="Divorciado" <?= ($usuario['estado_civil'] ?? '') === 'Divorciado' ? 'selected' : ''; ?>>Divorciado</option>
        <option value="Viúvo" <?= ($usuario['estado_civil'] ?? '') === 'Viúvo' ? 'selected' : ''; ?>>Viúvo</option>
    </select><br>

    <button type="submit">Atualizar</button>
</form>

<a href="./../">Voltar</a>

</body>
</html>