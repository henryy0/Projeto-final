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
    <link rel="stylesheet" href="css/sistema.css"> <!-- Alteração feita aqui -->
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
                        <a class="nav-link" href="chat/home2.php">Chat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="calendario/calendario.php">Calendário</a>
                    </li>
                    <!-- Include do menu dropdown -->
                    <?php include 'menu_dropdown.php'; ?>
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
