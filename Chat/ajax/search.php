<?php
// Inicia a sessão se não estiver definida
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include '../../includes/db.php';

    // Obtém o ID do usuário logado
    $id_usuario = $_SESSION['id_usuario'];

    // Prepara a consulta SQL para buscar usuários com base na chave de busca
    $key = "%" . $_POST['key'] . "%";
    $sql = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.foto_usuario, 
            IFNULL(MAX(m.criado_em), 'Nunca') AS ultima_atividade
            FROM Usuario u
            LEFT JOIN Mensagens m ON (u.id_usuario = m.de_id OR u.id_usuario = m.para_id)
            AND (m.de_id = ? OR m.para_id = ?)
            WHERE (u.login_usuario LIKE ? OR u.nome_usuario LIKE ?)
            AND u.id_usuario != ?
            GROUP BY u.id_usuario
            ORDER BY ultima_atividade DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssi", $id_usuario, $id_usuario, $key, $key, $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    // Exibe os usuários encontrados na busca
    if ($result->num_rows > 0) {
        while ($usuario = $result->fetch_assoc()) {
            // Obtém o ID do usuário atual
            $usuario_id = $usuario['id_usuario'];

            // Determina o status online/offline
            $ultima_atividade = $usuario['ultima_atividade'] == 'Nunca' ? 'Nunca' : 'Ativo recentemente';

            // Exibe o usuário na lista
            ?>
            <div class="user-list-item" data-userid="<?php echo $usuario_id; ?>" data-username="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>">
                <img src="uploads/<?php echo htmlspecialchars($usuario['foto_usuario']); ?>" class="w-10 rounded-circle">
                <h3 class="fs-xs m-2"><?php echo htmlspecialchars($usuario['nome_usuario']) . " " . htmlspecialchars($usuario['sobrenome_usuario']); ?></h3>
                <span>Última Atividade: <?php echo $ultima_atividade; ?></span>
            </div>
            <?php
        }
    } else {
        // Se nenhum usuário correspondente for encontrado, exibe uma mensagem informativa
        ?>
        <div class="alert alert-info text-center">
            <i class="fa fa-user-times d-block fs-big"></i>
            Nenhum usuário encontrado.
        </div>
    <?php
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    // Se o usuário não estiver logado, redireciona para a página de login
    header("Location: ../../index.php");
    exit;
}
?>
