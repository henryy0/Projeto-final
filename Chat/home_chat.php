<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <div class="chat-container">
        <div class="sidebar">
            <div class="profile">
                <img src="profile_picture.jpg" alt="Profile Picture">
                <!-- Exibir o nome do usuário logado -->
                <?php
                session_start();
                if (isset($_SESSION['id_usuario'])) {
                    echo "<h3>{$_SESSION['nome_usuario']}</h3>";
                }
                ?>
                <a href="../includes/logout.php">Sair</a>
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
                <input type="file" id="fileInput">
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
