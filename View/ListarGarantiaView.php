<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo_acesso'] == 3) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/ListarGarantiaViewModel.php';

$viewModel = new ListarGarantiaViewModel();
$filtros = [
    'garantia' => $_GET['garantia'] ?? null,
    'cpf' => $_GET['cpf'] ?? null,
    'rg' => $_GET['rg'] ?? null,
    'nome' => $_GET['nome'] ?? null,
];

$garantias = $viewModel->listarGarantias($filtros);

$exibirFiltros = isset($_SESSION['usuario']['id_tipo_acesso']) && $_SESSION['usuario']['id_tipo_acesso'] == 1;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['excluir_id'])) {
    $idGarantia = $_POST['excluir_id'];
    $viewModel->excluirGarantia($idGarantia);
    header("Location: ../");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Garantias</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            align-items: center;
            min-height: 100vh;
        }

        h1 {
            text-align: center;
            margin: 20px 0;
            color: #4a90e2;
        }

        form {
            max-width: 600px;
            margin: 20px auto;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        form input {
            flex: 1;
            padding: 10px;
            font-size: 1rem;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        form button {
            padding: 10px 20px;
            font-size: 1rem;
            color: #fff;
            background-color: #4a90e2;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        form button:hover {
            background-color: #357ab8;
        }

        table {
            width: fit-content;
            border-collapse: collapse;
            margin: 20px auto;
            max-width: 100%;
            overflow-x: auto;
            display: block;
        }

        table thead {
            background-color: #4a90e2;
            color: #fff;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ccc;
            white-space: nowrap;
        }

        table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        table tbody tr:hover {
            background-color: #f1f1f1;
        }

        a {
            text-decoration: none;
            color: #4a90e2;
        }

        a:hover {
            text-decoration: underline;
        }

        .actions a {
            margin-right: 10px;
        }

        @media (max-width: 768px) {
            form {
                flex-direction: column;
            }

            form input,
            form button {
                width: 100%;
            }

            table th, 
            table td {
                font-size: 0.9rem;
                padding: 8px;
            }
        }
    </style>
</head>
<body>

<h2>Listar Garantias</h2>
 
<?php if ($exibirFiltros): ?>
<form method="GET">
    <input type="text" name="garantia" placeholder="Número de Garantia" value="<?= htmlspecialchars($filtros['garantia'] ?? '') ?>">
    <input type="text" name="cpf" placeholder="CPF" value="<?= htmlspecialchars($filtros['cpf'] ?? '') ?>">
    <input type="text" name="rg" placeholder="RG" value="<?= htmlspecialchars($filtros['rg'] ?? '') ?>">
    <input type="text" name="nome" placeholder="Nome" value="<?= htmlspecialchars($filtros['nome'] ?? '') ?>">
    <button type="submit">Filtrar</button>
    <a href="./">Limpar Filtros</a>
</form>
<?php endif; ?>

<table>
    <thead>
        <tr>
            <th>Nº Garantia</th>
            <th>Revendedor</th>
            <th>Data Compra</th>
            <th>Modelo</th>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>Ações</th>
        </tr>
    </thead>
    <tbody>
        <?php if (empty($garantias)): ?>
            <tr>
                <td colspan="8" style="text-align: center;">Nenhuma garantia encontrada.</td>
            </tr>
        <?php else: ?>
            <?php foreach ($garantias as $garantia): ?>
                <tr>
                    <td><?= htmlspecialchars($garantia['garantia']) ?></td>
                    <td><?= htmlspecialchars($garantia['nome_revendedor']) ?></td>
                    <td><?= htmlspecialchars($garantia['data_compra']) ?></td>
                    <td><?= htmlspecialchars($garantia['modelo_piscina']) ?></td>
                    <td><?= htmlspecialchars($garantia['nome_completo']) ?></td>
                    <td><?= htmlspecialchars($garantia['cpf']) ?></td>
                    <td><?= htmlspecialchars($garantia['rg']) ?></td>
                    <td>
                        <a href="../editargarantia?id_garantia=<?= $garantia['id_garantia'] ?>">Editar</a>
                        <form method="POST" style="display: inline;">
                            <input type="hidden" name="excluir_id" value="<?= $garantia['id_garantia'] ?>">
                            <a href="<?= 
                                '../pdfgarantia/' .
                                $garantia['id_garantia'] .
                                $garantia['garantia'] .
                                '/garantia_original_piscinas_' .
                                $garantia['garantia'] .
                                '.pdf' ?>"
                            >
                                Visualizar PDF
                            </a>
                            <button type="submit" onclick="return confirm('Deseja excluir esta garantia?')">Excluir</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
    </tbody>
</table>

<a href="../">Voltar</a>

</body>
</html>