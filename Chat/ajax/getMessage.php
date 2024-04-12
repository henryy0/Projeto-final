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

        // Consulta para obter o caminho da imagem do usuário remetente
        $sql_de = "SELECT foto_usuario FROM Usuario WHERE id_usuario = ?";
        $stmt_de = $conn->prepare($sql_de);
        $stmt_de->bind_param("i", $de_id);
        $stmt_de->execute();
        $result_de = $stmt_de->get_result();

        // Consulta para obter o caminho da imagem do usuário destinatário
        $sql_para = "SELECT foto_usuario FROM Usuario WHERE id_usuario = ?";
        $stmt_para = $conn->prepare($sql_para);
        $stmt_para->bind_param("i", $para_id);
        $stmt_para->execute();
        $result_para = $stmt_para->get_result();

        // Verifica se a consulta foi bem-sucedida e se encontrou a imagem do usuário remetente
        if ($result_de && $result_de->num_rows > 0) {
            $row_de = $result_de->fetch_assoc();
        } else {
            // Se não houver resultado, define $row_de como null
            $row_de = null;
        }

        // Verifica se a consulta foi bem-sucedida e se encontrou a imagem do usuário destinatário
        if ($result_para && $result_para->num_rows > 0) {
            $row_para = $result_para->fetch_assoc();
        } else {
            // Se não houver resultado, define $row_para como null
            $row_para = null;
        }

        // Prepara e executa a consulta para obter as mensagens entre os usuários especificados
        $sql = "SELECT Mensagens.*, Usuario.nome_usuario
            FROM Mensagens 
            INNER JOIN Usuario ON Mensagens.de_id = Usuario.id_usuario
            WHERE (Mensagens.de_id = ? AND Mensagens.para_id = ?) 
            OR (Mensagens.de_id = ? AND Mensagens.para_id = ?) 
            ORDER BY Mensagens.criado_em ASC
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

                // Recupera o caminho da imagem do usuário remetente
                $caminho_imagem_de = ($row_de !== null) ? "../img/usuarios/" . $de_id . "/" . $row_de['foto_usuario'] : '';

                // Recupera o caminho da imagem do usuário destinatário
                $caminho_imagem_para = ($row_para !== null) ? "../img/usuarios/" . $para_id . "/" . $row_para['foto_usuario'] : '';

                // Exibe a mensagem formatada com a formatação desejada
                echo '<div class="mensagem ' . $classe_css . '">';
                echo '<img src="' . ($mensagem['de_id'] == $de_id ? $caminho_imagem_de : $caminho_imagem_para) . '" alt="Foto do Usuário" class="avatar">';
                echo '<div class="conteudo-mensagem">';
                echo '<p>' . htmlspecialchars($mensagem['mensagem']) . '</p>';
                echo '<small>' . htmlspecialchars($mensagem['nome_usuario']) . ' - ' . date("H:i", strtotime($mensagem['criado_em'])) . '</small>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            // Se não houver mensagens, exibe uma mensagem indicando isso
            echo '<p>Nenhuma mensagem encontrada.</p>';
        }

        // Fecha a conexão com o banco de dados
        $stmt_de->close();
        $stmt_para->close();
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
?>
