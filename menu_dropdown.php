<?php
if(isset($_SESSION['id_usuario'])) {
    // Conexão com o banco de dados
    $servername = "localhost";
    $username = "root"; // Insira seu usuário do banco de dados aqui
    $password = ""; // Insira sua senha do banco de dados aqui
    $dbname = "SistemaDeGerenciamento"; // Insira o nome do seu banco de dados aqui

    // Cria a conexão
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica a conexão
    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    // Obtém o ID do usuário logado
    $id_usuario = $_SESSION['id_usuario'];

    // Consulta para obter o caminho da imagem do usuário
    $sql = "SELECT foto_usuario FROM Usuario WHERE id_usuario = $id_usuario";
    $result = $conn->query($sql);

    // Verifica se a consulta foi bem-sucedida e se encontrou a imagem do usuário
    if ($result && $result->num_rows > 0) {
        // Exibe a imagem do usuário e o menu dropdown
        $row = $result->fetch_assoc();
        $caminho_imagem = "img/usuarios/" . $id_usuario . "/" . $row['foto_usuario'];

        echo '<li class="nav-item dropdown">';
        echo '<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';
        if(!empty($caminho_imagem)) {
            echo '<img src="' . $caminho_imagem . '" alt="Imagem do Usuário" class="rounded-circle" height="30" width="30">';
        } else {
            echo '<i class="fas fa-user"></i>';
        }
        echo ' ' . $_SESSION['nome_usuario']; // Adicionando o nome do usuário
        echo '</a>';
        echo '<div class="dropdown-menu" aria-labelledby="navbarDropdown">';
        echo '<a class="dropdown-item" href="usuarios/atualizar_perfil.php">Atualizar Perfil</a>';
        echo '<div class="dropdown-divider"></div>';
        echo '<a class="dropdown-item" href="includes/logout.php">Sair</a>';
        echo '</div>';
        echo '</li>';
    }
} else {
    // Se o usuário não estiver logado, exibe o link de login
    echo '
    <li class="nav-item">
        <a class="nav-link" href="index.php"><i class="fas fa-sign-in-alt"></i> Login</a>
    </li>';
}
?>
