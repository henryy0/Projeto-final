<?php
session_start();

if (isset($_SESSION['id_usuario'])) {
    # Arquivo de conexão com o banco de dados
    include '../includes/db.php';

    include 'app/suporte/usuario.php';
    include 'app/suporte/chat.php';
    include 'app/suporte/visualizada.php';
    include 'app/suporte/tempoDecorrido.php';

    # Obtendo dados do usuário
    $user = getUser($_SESSION['id_usuario'], $conn);

    # Obtendo o ID do usuário com quem está conversando
    $chatWithId = isset($_GET['id']) ? $_GET['id'] : null; // Corrigido para 'id'

    // Verificar se o ID do usuário com quem está conversando está definido
    if ($chatWithId !== null) {
        # Obtendo dados do usuário com quem está conversando
        $chatWith = getUser($chatWithId, $conn);

        # Obtendo conversas do usuário
        $conversations = getConversation($user['id_usuario'], $chatWithId, $conn);

    } else {
        echo "ID do usuário com quem está conversando não definido.";
    }
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="../img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="w-400 shadow p-4 rounded">
        <a href="home.php" class="fs-4 link-dark">&#8592;</a>

        <div class="d-flex align-items-center">
            <?php if (isset($chatWith)) { ?>
            <img src="uploads/<?= $chatWith['foto_usuario'] ?>" class="w-15 rounded-circle">
            <?php } ?>

            <?php if (isset($chatWith)) { ?>
            <h3 class="display-4 fs-sm m-2">
                <?= $chatWith['nome_usuario'] ?> <br>
                <div class="d-flex align-items-center" title="online">
                    <?php if (last_seen($chatWith['ultimo_acesso']) == "Active") { ?>
                        <div class="online"></div>
                        <small class="d-block p-1">Online</small>
                    <?php } else { ?>
                        <small class="d-block p-1">
                            Last seen: <?= last_seen($chatWith['ultimo_acesso']) ?>
                        </small>
                    <?php } ?>
                </div>
            </h3>
            <?php } ?>
        </div>

        <div class="shadow p-4 rounded d-flex flex-column mt-2 chat-box" id="chatBox">
            <?php if (!empty($conversations)) { ?>
                <?php foreach ($conversations as $chat) { ?>
                    <?php if ($chat['de_id'] == $_SESSION['id_usuario']) { ?>
                        <p class="rtext align-self-end border rounded p-2 mb-1">
                            <?= $chat['mensagem'] ?>
                            <small class="d-block"><?= $chat['criado_em'] ?></small>
                        </p>
                    <?php } else { ?>
                        <p class="ltext border rounded p-2 mb-1">
                            <?= $chat['mensagem'] ?>
                            <small class="d-block"><?= $chat['criado_em'] ?></small>
                        </p>
                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <div class="alert alert-info text-center">
                    <i class="fa fa-comments d-block fs-big"></i>
                    Nenhuma mensagem ainda. Inicie a conversa.
                </div>
            <?php } ?>
        </div>
        <div class="input-group mb-3">
            <textarea cols="3" id="message" class="form-control"></textarea>
            <button class="btn btn-primary" id="sendBtn">
                <i class="fa fa-paper-plane"></i>
            </button>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        var scrollDown = function() {
            let chatBox = document.getElementById('chatBox');
            chatBox.scrollTop = chatBox.scrollHeight;
        }

        scrollDown();

        $(document).ready(function() {

            $("#sendBtn").on('click', function() {
                message = $("#message").val();
                if (message == "") return;

                $.post("app/ajax/insert.php", {
                        message: message,
                        to_id: <?= isset($chatWith['id_usuario']) ? $chatWith['id_usuario'] : 'null' ?>
                    },
                    function(data, status) {
                        $("#message").val("");
                        $("#chatBox").append(data);
                        scrollDown();
                    });
            });

            let lastSeenUpdate = function() {
                $.get("app/ajax/update_last_seen.php");
            }
            lastSeenUpdate();

            setInterval(lastSeenUpdate, 10000);

            let fechData = function() {
                $.post("app/ajax/getMessage.php", {
                        id_2: <?= isset($chatWith['id_usuario']) ? $chatWith['id_usuario'] : 'null' ?>
                    },
                    function(data, status) {
                        $("#chatBox").append(data);
                        if (data != "") scrollDown();
                    });
            }

            fechData();

            setInterval(fechData, 500);

        });
    </script>
</body>

</html>
<?php
} else {
    // Se o usuário não estiver autenticado, redirecione-o para a página de login ou exiba uma mensagem de erro.
}
?>
