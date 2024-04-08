<?php
// Verifique se a sessão está iniciada
session_start();

// Verifique se o usuário está autenticado
if (isset($_SESSION['id_usuario'])) {
    // Inclua o arquivo de conexão com o banco de dados
    include '../includes/db.php';

    // Inclua outros arquivos necessários
    include 'app/suporte/usuario.php';
    include 'app/suporte/chat.php';
    include 'app/suporte/visualizada.php';
    include 'app/suporte/tempoDecorrido.php';

    // Obtendo dados do usuário
    $user = getUser($_SESSION['id_usuario'], $conn);
    
    // Verificar se a chave 'id_usuario' está presente no array $user
    if (isset($user['id_usuario'])) {
        // Verificar se 'id_usuario' está definido em $_GET
        if(isset($_GET['id_usuario'])) {
            // Obtendo conversas do usuário
            $chatWithId = $_GET['id_usuario'];
            $conversations = getConversation($user['id_usuario'], $chatWithId, $conn);

        } else {
            echo "O parâmetro 'id_usuario' não está definido na URL.";
        }
    } else {
        echo "A chave 'id_usuario' não está presente no array \$user.";
    }
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat App - Home2</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body class="d-flex justify-content-center align-items-center vh-100">
    <div class="p-2 w-400 rounded shadow">
        <div>
            <div class="d-flex mb-3 p-3 bg-light justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="uploads/<?= $user['foto_usuario'] ?>" class="w-25 rounded-circle">
                    <h3 class="fs-xs m-2"><?= $user['nome_usuario'] ?></h3>
                </div>
                <a href="../includes/logout.php" class="btn btn-dark">Sair</a>
            </div>

            <div class="input-group mb-3">
                <input type="text" placeholder="Search..." id="searchText" class="form-control">
                <button class="btn btn-primary" id="searchBtn">
                    <i class="fa fa-search"></i>
                </button>
            </div>
            <ul id="chatList" class="list-group mvh-50 overflow-auto">
                <?php if (!empty($conversations)) { ?>
                    <?php foreach ($conversations as $conversation) { ?>
                        <li class="list-group-item">
                            <a href="chat.php?id_usuario=<?= $conversation['id_usuario'] ?>" class="d-flex justify-content-between align-items-center p-2">
                                <div class="d-flex align-items-center">
                                    <img src="uploads/<?= $conversation['foto_usuario'] ?>" class="w-10 rounded-circle">
                                    <h3 class="fs-xs m-2">
                                        <?= $conversation['nome_usuario'] ?><br>
                                        <small>
                                            <?php
                                            echo lastChat($_SESSION['id_usuario'], $conversation['id_usuario'], $conn);
                                            ?>
                                        </small>
                                    </h3>
                                </div>
                                <?php if (last_seen($conversation['ultimo_acesso']) == "Active") { ?>
                                    <div title="online">
                                        <div class="online"></div>
                                    </div>
                                <?php } ?>
                            </a>
                        </li>
                    <?php } ?>
                <?php } else { ?>
                    <div class="alert alert-info text-center">
                        <i class="fa fa-comments d-block fs-big"></i>
                        Nenhuma mensagem ainda, comece a conversar
                    </div>
                <?php } ?>
            </ul>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <script>
        $(document).ready(function() {

            // Procurar
            $("#searchText").on("input", function() {
                var searchText = $(this).val();
                if (searchText == "") return;
                $.post('app/ajax/search.php', {
                        key: searchText
                    },
                    function(data, status) {
                        $("#chatList").html(data);
                    });
            });

            // Pesquisar usando o botão
            $("#searchBtn").on("click", function() {
                var searchText = $("#searchText").val();
                if (searchText == "") return;
                $.post('app/ajax/search.php', {
                        key: searchText
                    },
                    function(data, status) {
                        $("#chatList").html(data);
                    });
            });

            // Atualização automática vista pela última vez para usuário logado
            let lastSeenUpdate = function() {
                $.get("app/ajax/update_last_seen.php");
            }

            lastSeenUpdate();

            // Atualização automática vista pela última vez a cada 10 segundos
            setInterval(lastSeenUpdate, 10000);

        });
    </script>
</body>

</html>
<?php
}
?>
