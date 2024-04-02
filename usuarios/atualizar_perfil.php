<?php
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['id_usuario'])) {
    // Se não estiver logado, redireciona para a página de login
    header("Location: usuarios/login.php");
    exit();
}

// Inclui o arquivo de conexão com o banco de dados
include_once "../includes/db.php";

// Inicializa as variáveis
$nome = $email = $senha = $foto_atual = $mensagem = "";
$erro = false;

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Processa os dados do formulário de atualização de perfil

    // Valida e sanitiza os dados recebidos do formulário
    $nome = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);
    $foto_nova = $_FILES["foto"]["name"];
    $foto_atual = $_POST["foto_atual"];

    // Verifica se uma nova foto foi enviada
    if (!empty($foto_nova)) {
        // Remove a foto atual
        if (!empty($foto_atual)) {
            unlink("img/usuarios/" . $_SESSION['id_usuario'] . "/" . $foto_atual);
        }
        // Move a nova foto para o diretório de imagens do usuário
        $caminho_foto = "img/usuarios/" . $_SESSION['id_usuario'] . "/" . $foto_nova;
        move_uploaded_file($_FILES["foto"]["tmp_name"], $caminho_foto);
    } else {
        // Mantém a foto atual se nenhuma nova foi enviada
        $caminho_foto = $foto_atual;
    }

    // Atualiza os dados do perfil no banco de dados
    $sql = "UPDATE Usuario SET nome = '$nome', email = '$email', senha = '$senha', foto_usuario = '$foto_nova' WHERE id_usuario = " . $_SESSION['id_usuario'];

    if ($conn->query($sql) === TRUE) {
        // Redireciona o usuário de volta para a página de sistema após a atualização do perfil
        header("Location: sistema.php");
        exit();
    } else {
        $mensagem = "Erro ao atualizar o perfil: " . $conn->error;
        $erro = true;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atualizar Perfil</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="../css/atualizar_perfil.css">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/favicon.png">
</head>

<body>

    <div class="container">
        <h2>Atualizar Perfil</h2>
        <?php if ($erro) : ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $mensagem; ?>
            </div>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nome">Nome:</label>
                <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $nome; ?>" required>
            </div>
            <div class="form-group">
                <label for="email">E-mail:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
            </div>
            <div class="form-group">
                <label for="senha">Nova Senha:</label>
                <input type="password" class="form-control" id="senha" name="senha" required>
            </div>
            <div class="form-group">
                <label for="foto">Foto de Perfil:</label>
                <input type="file" class="form-control-file" id="foto" name="foto">
                <input type="hidden" name="foto_atual" value="<?php echo $foto_atual; ?>">
                <?php if (!empty($foto_atual)) : ?>
                    <img src="img/usuarios/<?php echo $_SESSION['id_usuario'] . "/" . $foto_atual; ?>" alt="Foto de Perfil Atual" class="img-thumbnail mt-2" width="100">
                <?php endif; ?>
            </div>
            <button type="submit" class="btn btn-primary">Atualizar</button>
        </form>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
