<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Esqueceu a senha</title>
    <link rel="stylesheet" href="../css/esqueceu_senha.css">
</head>
<body>
    <div class="container">
        <h2>Esqueceu a senha</h2>
        <form action="enviar_email_senha.php" method="post" class="form">
            <div class="form-group">
                <label for="email">Digite seu e-mail:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <button type="submit">Enviar e-mail de recuperação</button>
        </form>
    </div>
</body>
</html>
