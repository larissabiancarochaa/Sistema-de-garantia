<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo_acesso'] == 3) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/BuscarGarantiaViewModel.php';

$viewModel = new BuscarGarantiaViewModel();
$mensagem = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpf = $_POST['cpf'] ?? '';
    $numeroGarantia = $_POST['numero_garantia'] ?? null;

    $resultado = $viewModel->buscarGarantias($cpf, $numeroGarantia);

    if ($resultado['success']) {
        $_SESSION['filtros_busca'] = [
            'cpf' => $cpf,
            'numero_garantia' => $numeroGarantia
        ];

        // Montando a URL com base nos parâmetros de busca
        if ($numeroGarantia) {
            header("Location: ../listargarantias?cpf=$cpf&garantia=$numeroGarantia");
        } else {
            header("Location: ../listargarantias?cpf=$cpf");
        }
        exit;
    } else {
        $mensagem = $resultado['message'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Garantia</title>

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
            height: 100vh;
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
            max-width: 400px;
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

        input[type="text"] {
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

<h2>Buscar Garantia</h2>

<?php if ($mensagem): ?>
    <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
<?php endif; ?>

<form method="POST">
    <label for="cpf">CPF:</label>
    <input type="text" id="cpf" name="cpf" required maxlength="14">

    <label for="numero_garantia">Número de Garantia:</label>
    <input type="text" id="numero_garantia" name="numero_garantia">

    <button type="submit">Buscar Garantia</button>
</form>

<a href="./../">Voltar</a>

</body>
</html>
