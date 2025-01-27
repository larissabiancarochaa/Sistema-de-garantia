<?php
session_start();

if (!isset($_SESSION['usuario']) || $_SESSION['usuario']['id_tipo_acesso'] == 3) {
    header("Location: ../login");
    exit;
}

require_once __DIR__ . '/../ViewModel/CadastrarUsuarioViewModel.php';

$viewModel = new CadastrarUsuarioViewModel();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = $viewModel->cadastrarUsuario($_POST);
}

$id_tipo_acesso = $_SESSION['usuario']['id_tipo_acesso'];
?>

    <!DOCTYPE html>
    <html lang="pt-BR">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Cadastrar Usuário</title>

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
            input[type="email"],
            input[type="date"],
            select {
                width: 100%;
                padding: 10px;
                margin-bottom: 15px;
                border: 1px solid #ccc;
                border-radius: 4px;
                box-sizing: border-box;
            }

            input:focus, 
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
        
        <script defer src="../Assets/Js/buscarcep.js"></script>
    </head>
    <body>

    <h2>Cadastrar Usuário</h2>
        
    <?php if (isset($mensagem)): ?>
        <p><?= htmlspecialchars($mensagem, ENT_QUOTES, 'UTF-8'); ?></p>
    <?php endif; ?>

    <form method="POST">
        <label>Nome Completo:</label>
        <input type="text" name="nome_completo" required><br>

        <label>Email:</label>
        <input type="email" name="email" required><br>

        <label>CPF:</label>
        <input type="text" name="cpf" maxlength="11" required><br>

        <label>RG:</label>
        <input type="text" name="rg" maxlength="9" required><br>

        <label>Telefone:</label>
        <input type="text" name="telefone" maxlength="11" required><br>

        <label>CEP:</label>
        <input type="text" name="cep" onblur="buscarCep()" require><br>

        <label>Endereço:</label>
        <input type="text" name="endereco" required><br>

        <label>Número:</label>
        <input type="text" name="numero" required><br>

        <label>Bairro:</label>
        <input type="text" name="bairro" required><br>

        <label>Cidade:</label>
        <input type="text" name="cidade"><br>

        <label>Estado:</label>
        <input type="text" name="estado"><br>

        <label>Data de Nascimento:</label>
        <input type="date" name="data_nascimento" require><br>

        <label>Estado Civil:</label>
        <select name="estado_civil">
            <option value="Solteiro">Solteiro</option>
            <option value="Casado">Casado</option>
            <option value="Divorciado">Divorciado</option>
            <option value="Viúvo">Viúvo</option>
        </select><br>

        <?php if ($id_tipo_acesso == 1): ?>
            <label>Tipo de Acesso:</label>
            <select name="id_tipo_acesso">
                <option value="1">Administrador</option>
                <option value="2">Usuário Licenciado</option>
            </select><br>
        <?php endif; ?>

        <button type="submit">Cadastrar</button>
    </form>

    <a href="../">Voltar</a>

</body>
</html>