<?php
session_start();
include '../includes/db.php'; // Inclui o arquivo de conexão com o banco de dados
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="../css/chat.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" type="image/png" href="../img/logo.png">
</head>
<body>
    <div class="chat-container">
        <div class="sidebar">
            <div class="profile">
                <!-- Exibir a imagem do usuário -->
                <?php
                if (isset($_SESSION['id_usuario'])) {
                    $id_usuario = $_SESSION['id_usuario'];
                    $sql = "SELECT foto_usuario FROM Usuario WHERE id_usuario = $id_usuario";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        $row = $result->fetch_assoc();
                        $caminho_imagem = "../img/usuarios/" . $id_usuario . "/" . $row['foto_usuario'];
                        if (file_exists($caminho_imagem)) {
                            echo "<img src='$caminho_imagem' alt='Profile Picture'>";
                        } else {
                            echo "<p>Imagem não encontrada</p>";
                        }
                    }
                }
                ?>
                <!-- Exibir o nome do usuário logado -->
                <?php
                if (isset($_SESSION['nome_usuario'])) {
                    echo "<h3>{$_SESSION['nome_usuario']}</h3>";
                }
                ?>
                <a href="../includes/logout.php" class="logout-link">Sair</a>
            </div>
            <div class="search-box">
                <input type="text" id="searchUser" placeholder="Buscar usuários">
                <!-- Aqui serão exibidos os resultados da busca -->
                <div id="searchResult"></div>
            </div>
            <div class="user-list">
                <!-- Lista de usuários -->
            </div>
        </div>
        <div class="chat">
            <div class="chat-header" id="recipientInfo">
                <!-- Aqui serão exibidas as informações do destinatário selecionado -->
            </div>
            <div class="chat-messages" id="chatMessages">
                <!-- Mensagens do chat -->
            </div>
            <div class="chat-input">
                <input type="text" id="messageInput" placeholder="Digite sua mensagem">
                <div class="custom-file-input">
                    <input type="file" id="fileInput">
                    <label for="fileInput" class="file-label">
                        <span class="file-icon">
                            <i class="fas fa-cloud-upload-alt"></i>
                        </span>
                        <span class="file-text">Escolher Arquivo</span>
                    </label>
                </div>
                <button id="sendBtn">Enviar</button>
                <!-- Adiciona um campo oculto para armazenar o ID do destinatário -->
                <input type="hidden" id="recipientId" value="">
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="../js/chat.js"></script>
</body>
</html>
