<?php
session_start();

// Verifica se o usuário já está logado
if (isset($_SESSION['usuario'])) {
    $id_tipo_acesso = $_SESSION['usuario']['id_tipo_acesso'];

    // Redireciona o usuário dependendo do tipo de acesso
    switch ($id_tipo_acesso) {
        case 1:
            header("Location: ./adm/");
            exit;
        case 2:
            header("Location: ./licenciado/");
            exit;
        case 3:
            header("Location: ./garantia/");
            exit;
        default:
            header("Location: ./login/");
            exit;
    }
}

require_once __DIR__ . '/../ViewModel/LoginViewModel.php';

$viewModel = new LoginViewModel();
$error = null;
$showGarantieForm = isset($_GET['garantia']); // Para decidir qual formulário exibir

// Processa o login
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if ($showGarantieForm) {
        $error = $viewModel->handleGarantia($_POST['cpf'], $_POST['garantia']);
    } else {
        $error = $viewModel->handleLogin($_POST['email'], $_POST['senha']);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $showGarantieForm ? 'Consulta de Garantia' : 'Login'; ?></title>
    <link rel="stylesheet" href="../Assets/Css/style.css">
    <script defer src="../Assets/Js/login.js"></script>
    <style scoped>
            body {
                background-color: #F5F5F5;
                display: flex;
                justify-content: center;
                align-items: center;
                margin: 0;
                height: 100vh;
            }

            .login-title {
                text-align: center;
                color: #007BFF;
                margin-bottom: 1rem;
            }

            .error-message {
                background: #FF4D4D;
                padding: 10px;
                border-radius: 10px;
                color: white;
                box-shadow: 0 0 15px 0 #0000004a;
            }

            .form-input {
                padding: 0.5rem;
                border: 1px solid #CCC;
                border-radius: 4px;
                flex: 1;
                outline: none; 
            }

            .form-input:focus {
                border: 1px solid #007BFF;
            }

            .form-group {
                display: flex;
                flex-direction: column;
                gap: 5px;
            }

            .login-form--email, .login-form--garantia {
                background: white;
                padding: 30px;
                box-shadow: 0 0 15px 0 #0000004a;
                border-radius: 20px;
                display: flex;
                flex-direction: column;
                gap: 15px;
            }

            .form-button {
                background-color: #007BFF;
                color: white;
                padding: 0.75rem;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                font-size: 1rem;
            }

            .form-button:hover {
                background-color: #0056b3;
            }

            .password-container {
                display: flex;
            }
    </style>
</head>
<body class="login-container">
    <div class="login-wrapper">
        <h2 class="login-title">
            <?php echo $showGarantieForm ? 'Consulta de Garantia' : 'Login'; ?>
        </h2>
        
        <?php if ($error): ?>
            <p class="error-message" id="error-message"><?php echo $error; ?></p>
        <?php endif; ?>

        <?php if ($showGarantieForm): ?>
            <form method="POST" class="login-form login-form--garantia">
                <div class="form-group">
                    <label for="cpf" class="form-label">CPF:</label>
                    <input type="text" id="cpf" name="cpf" class="form-input" maxlength="14">
                </div>
                <div class="form-group">
                    <label for="garantia" class="form-label">Número da Garantia:</label>
                    <input type="text" id="garantia" name="garantia" class="form-input">
                </div>
                <button type="submit" class="form-button">Consultar Garantia</button>
            </form>
        <?php else: ?>
            <form method="POST" class="login-form login-form--email">
                <div class="form-group">
                    <label for="email" class="form-label">E-mail:</label>
                    <input type="email" id="email" name="email" class="form-input">
                </div>
                <div class="form-group">
                    <label for="senha" class="form-label">Senha:</label>
                    <div class="password-container">
                        <input type="password" id="senha" name="senha" class="form-input" maxlength="11">
                        <button type="button" id="togglePassword" class="toggle-password">👁</button>
                    </div>
                </div>
                <button type="submit" class="form-button">Entrar</button>
            </form>
        <?php endif; ?>
    </div>
</body>
</html>