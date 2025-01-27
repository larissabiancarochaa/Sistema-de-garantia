<?php
session_start();

if (!isset($_SESSION['usuario']) || !in_array($_SESSION['usuario']['id_tipo_acesso'], [1, 2])) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/ListarUsuariosViewModel.php';
require_once __DIR__ . '/../Model/AuthModel.php';

// Suponha que você tenha o ID do usuário logado na sessão
$idUsuario = $_SESSION['usuario']['id_usuario'];

$viewModel = new ListarUsuariosViewModel();

// Verifica se o usuário é administrador
$isAdmin = $viewModel->isAdmin($idUsuario);

// Filtrar por ID se o parâmetro estiver na URL
$id = isset($_GET['id']) ? intval($_GET['id']) : null;
$filter = isset($_GET['filter']) ? $_GET['filter'] : null;

// Excluir usuário se a ação for delete
if (isset($_GET['action']) && $_GET['action'] === 'delete' && $id) {
    if ($viewModel->deleteUsuario($id)) {
        echo "<p>Usuário excluído com sucesso!</p>";
    } else {
        echo "<p>Erro ao excluir o usuário.</p>";
    }
}

// Obter a lista de usuários (filtrada ou completa)
$usuarios = $viewModel->getUsuarios($id, $filter);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Usuários</title>

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
    <h1>Lista de Usuários</h1>

    <?php if ($isAdmin): ?>
        <form method="GET">
            <label for="filter">Filtrar por nome ou CPF:</label>
            <input type="text" name="filter" id="filter" value="<?= htmlspecialchars($filter) ?>">
            <button type="submit">Filtrar</button>
        </form>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nome Completo</th>
                <th>Email</th> 
                <th>CPF</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($usuarios)): ?>
                <?php foreach ($usuarios as $usuario): ?>
                    <tr>
                        <td><?= $usuario['id_usuario'] ?></td>
                        <td><?= htmlspecialchars($usuario['nome_completo']) ?></td>
                        <td><?= htmlspecialchars($usuario['email']) ?></td>
                        <td><?= $usuario['cpf'] ?></td>
                        <td class="actions">
                            <a href="../editarusuario?id=<?= $usuario['id_usuario'] ?>">Editar</a>
                            <a href="?action=delete&id=<?= $usuario['id_usuario'] ?>" onclick="return confirm('Deseja realmente excluir este usuário?')">Excluir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">Nenhum usuário encontrado.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <a href="../">Voltar</a>
</body>
</html>