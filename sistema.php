<?php
session_start();
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CollaboraPro</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="css/sistem.css"> <!-- Alteração feita aqui -->
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="img/logo.png">
</head>


<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">
                <img src="img/logo.png" alt="Logo" height="30" class="mr-2">
                CollaboraPro
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="tarefas/tarefas.php">Tarefa</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="projetos/projetos.php">Projeto</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="equipe/equipe.php">Equipe</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="chat/chat.php">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario/calendario.php">Calendário</a>
                    </li>
                    <?php
                    if(isset($_SESSION['id_usuario'])) {
                        // Se o usuário estiver logado, exibe o menu do perfil com o nome do usuário
                        echo '
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
                            if(isset($_SESSION['foto_usuario'])) {
                                echo '<img src="img/usuarios/'.$_SESSION['id_usuario'].'/'.$_SESSION['foto_usuario'].'" alt="Imagem do Usuário" class="rounded-circle" height="30" width="30">';
                            } else {
                                echo '<i class="fas fa-user"></i>';
                            }
                            echo ' ' . $_SESSION['nome_usuario']; // Adicionando o nome do usuário
                            echo '</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="usuarios/atualizar_perfil.php">Atualizar Perfil</a>
                                <a class="dropdown-item" href="usuarios/logout.php">Sair</a>
                            </div>
                        </li>';
                    } else {
                        // Se o usuário não estiver logado, exibe o link de login
                        echo '
                        <li class="nav-item">
                            <a class="nav-link" href="index.php"><i class="fas fa-sign-in-alt"></i> Login</a>
                        </li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container mt-4">
        <?php
        // Incluir o conteúdo da tela solicitada
        if(isset($_GET['tela'])) {
            $tela = $_GET['tela'];
            switch ($tela) {
                case 'tarefa':
                    include_once("tarefas/tarefas.php");
                    break;
                case 'projeto':
                    include_once("projetos/projetos.php");
                    break;
                case 'equipe':
                    include_once("equipe/equipe.php");
                    break;
                case 'chat':
                    include_once("chat/chat.php");
                    break;
                case 'calendario':
                    include_once("calendario/calendario.php");
                    break;
                default:
                    include_once("home.php");
                    break;
            }
        } else {
            include_once("home.php"); 
        }
        ?>
    </div>

    <!-- Footer -->
    <footer class="footer mt-4">
        <div class="container">
            <div class="row">
                <div class="col text-center">
                    <p>&copy; <?php echo date("Y"); ?> CollaboraPro</p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
