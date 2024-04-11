<?php
session_start();

// Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    // Verifica se os parâmetros esperados foram recebidos via POST
    if (isset($_POST['para_id'])) {
        // Inclui o arquivo de configuração do banco de dados
        include '../../includes/db.php';

        // Parâmetros para paginação e carregamento dinâmico
        $pagina_atual = isset($_POST['pagina']) ? $_POST['pagina'] : 1;
        $mensagens_por_pagina = 10;
        $offset = ($pagina_atual - 1) * $mensagens_por_pagina;

        // Obtém o ID do usuário logado da SESSÃO
        $de_id = $_SESSION['id_usuario'];
        $para_id = $_POST['para_id'];

        // Prepara e executa a consulta para obter as mensagens entre os usuários especificados
        $sql = "SELECT Mensagens.*, Usuario.nome_usuario
                FROM Mensagens 
                INNER JOIN Usuario ON Mensagens.de_id = Usuario.id_usuario
                WHERE (Mensagens.de_id = ? AND Mensagens.para_id = ?) 
                OR (Mensagens.de_id = ? AND Mensagens.para_id = ?) 
                ORDER BY Mensagens.criado_em DESC 
                LIMIT ? OFFSET ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiii", $de_id, $para_id, $para_id, $de_id, $mensagens_por_pagina, $offset);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há mensagens retornadas
        if ($result->num_rows > 0) {
            // Exibe o histórico de mensagens anteriores
            while ($mensagem = $result->fetch_assoc()) {
                // Define a classe CSS com base no remetente da mensagem
                $classe_css = ($mensagem['de_id'] == $de_id) ? 'mensagem-saida' : 'mensagem-entrada';

                // Exibe a mensagem formatada com a formatação desejada
                echo '<div class="mensagem ' . $classe_css . '">';
                echo '<img src="' . getUserAvatar($mensagem['de_id']) . '" alt="Avatar" class="avatar">';
                echo '<p>' . htmlspecialchars($mensagem['mensagem']) . '</p>';
                echo '<small>' . htmlspecialchars($mensagem['nome_usuario']) . ' - ' . htmlspecialchars($mensagem['criado_em']) . '</small>';
                echo '</div>';
            }
        } else {
            // Se não houver mensagens, exibe uma mensagem indicando isso
            echo '<p>Nenhuma mensagem encontrada.</p>';
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
        
    } else {
        // Se os parâmetros esperados não foram recebidos, retorna uma mensagem de erro
        echo 'Erro: Parâmetros ausentes na requisição.';
    }
} else {
    // Se o usuário não estiver logado, redireciona para a página de login
    header("Location: ../../index.php");
    exit;
}

// Função para obter o avatar do usuário
function getUserAvatar($usuario_id) {
    // Lógica para obter o avatar do usuário do banco de dados ou de um diretório de arquivos
    return "avatars/avatar_" . $usuario_id . ".jpg";
}
?>
