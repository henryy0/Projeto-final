<?php
// Verifica se a sessão não está definida e, em seguida, a inicia
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include '../../includes/db.php';

    try {
        // Obtém o ID do usuário logado da SESSÃO
        $id_usuario = $_SESSION['id_usuario'];

        // Prepara e executa a consulta para atualizar o campo 'ultimo_acesso'
        $sql_update = "UPDATE Usuario
                SET ultimo_acesso = CURRENT_TIMESTAMP
                WHERE id_usuario = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->execute([$id_usuario]);

        // Prepara a consulta SQL para recuperar os usuários com quem o usuário logado já trocou mensagens
        $sql_mensagens = "SELECT u.id_usuario, u.nome_usuario, u.sobrenome_usuario, u.foto_usuario, 
                                u.ultimo_acesso, MAX(m.criado_em) AS ultima_atividade,
                                MAX(CASE WHEN m.de_id = ? THEN m.mensagem END) AS texto_enviado,
                                MAX(CASE WHEN m.para_id = ? THEN m.mensagem END) AS texto_recebido
                          FROM Usuario u
                          LEFT JOIN Mensagens m ON (u.id_usuario = m.de_id OR u.id_usuario = m.para_id)
                          AND (m.de_id = ? OR m.para_id = ?)
                          WHERE u.id_usuario != ?
                          GROUP BY u.id_usuario
                          ORDER BY u.ultimo_acesso DESC";
        $stmt_mensagens = $conn->prepare($sql_mensagens);
        $stmt_mensagens->bind_param("iiiii", $id_usuario, $id_usuario, $id_usuario, $id_usuario, $id_usuario);
        $stmt_mensagens->execute();
        $result_mensagens = $stmt_mensagens->get_result();

        // Exibe os usuários com quem o usuário logado já trocou mensagens anteriormente
        if ($result_mensagens->num_rows > 0) {
            while ($usuario = $result_mensagens->fetch_assoc()) {
                // Obtém o ID do usuário atual
                $usuario_id = $usuario['id_usuario'];

                // Determina o status online/offline
                $ultimo_acesso = $usuario['ultimo_acesso'] ? date('H:i', strtotime($usuario['ultimo_acesso'])) : 'Nunca acessou';

                // Exibe a última mensagem
                $ultima_mensagem = '';
                if ($usuario['texto_enviado'] !== null) {
                    $ultima_mensagem = htmlspecialchars($usuario['texto_enviado']);
                } elseif ($usuario['texto_recebido'] !== null) {
                    $ultima_mensagem = htmlspecialchars($usuario['texto_recebido']);
                } else {
                    $ultima_mensagem = 'Nenhuma mensagem';
                }

                // Exibe o usuário na lista
                ?>
                <div class="user-list-item" data-userid="<?php echo $usuario_id; ?>" data-username="<?php echo htmlspecialchars($usuario['nome_usuario']); ?>">
                    <img src="uploads/<?php echo htmlspecialchars($usuario['foto_usuario']); ?>" class="w-10 rounded-circle">
                    <h3 class="fs-xs m-2"><?php echo htmlspecialchars($usuario['nome_usuario']) . " " . htmlspecialchars($usuario['sobrenome_usuario']); ?></h3>
                    <span>Último Acesso: <?php echo $ultimo_acesso; ?></span>
                    <p>Última Mensagem: <?php echo $ultima_mensagem; ?></p>
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
        $stmt_mensagens->close();
        $stmt_update->close();
        $conn->close();
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro ou faz o tratamento adequado
        echo "Erro ao buscar usuários: " . $e->getMessage();
    }
} else {
    // Redireciona para a página de login se o usuário não estiver logado
    header("Location: ../../index.php");
    exit;
}
?>
