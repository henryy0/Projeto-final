<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="img/logo.png">
</head>
<body>
    <div class="container">
        <h2>Login</h2>
        <form action="usuarios/processar_login.php" method="post">
            <div class="form-group input-icon">
                <label for="login">Login:</label>
                <i class="fas fa-user"></i>
                <input type="text" id="login" name="login" required>
            </div>
            <div class="form-group input-icon">
                <label for="senha">Senha:</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="senha" name="senha" required>
            </div>
            <button type="submit">Entrar</button>
        </form>
        <div class="forgot-password-link">
            <p><a href="usuarios/esqueceu_senha.php" class="forgot-password-btn">Esqueceu a senha?</a></p>
        </div>
        <div class="signup-link">
            <p>Não tem uma conta? <a href="usuarios/cadastro.php">Cadastre-se</a></p>
        </div>
        <?php
        // Exibe mensagem de erro se houver
        if (isset($_GET['error']) && $_GET['error'] === 'login_failed') {
            echo '<p class="error-message">Login ou senha incorretos. Tente novamente.</p>';
        }
        ?>
    </div>
</body>
</html>
