<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
    <div class="container">
        <h2>Cadastro</h2>
        <form action="cadastrar_usuario.php" method="post" enctype="multipart/form-data">
            <div class="form-group input-icon">
                <label for="nome">Nome:</label>
                <i class="fas fa-user"></i>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="form-group input-icon">
                <label for="sobrenome">Sobrenome:</label>
                <i class="fas fa-user"></i>
                <input type="text" id="sobrenome" name="sobrenome">
            </div>
            <div class="form-group input-icon">
                <label for="email">E-mail:</label>
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group input-icon">
                <label for="telefone">Telefone:</label>
                <i class="fas fa-phone"></i>
                <input type="text" id="telefone" name="telefone">
            </div>
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
            <div class="form-group input-icon">
                <label for="confirmar_senha">Confirmar Senha:</label>
                <i class="fas fa-lock"></i>
                <input type="password" id="confirmar_senha" name="confirmar_senha" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto de Perfil:</label>
                <input type="file" id="foto" name="foto">
            </div>
            <button type="submit">Cadastrar</button>
        </form>
        <div class="login-link">
            <p>Já tem uma conta? <a href="../index.php">Faça login</a></p>
        </div>
    </div>
</body>
</html>
