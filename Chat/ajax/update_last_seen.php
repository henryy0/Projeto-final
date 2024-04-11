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
        $id = $_SESSION['id_usuario'];

        // Prepara e executa a consulta para atualizar o campo 'ultimo_acesso'
        $sql = "UPDATE Usuario
                SET ultimo_acesso = CURRENT_TIMESTAMP
                WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$id]);
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro ou faz o tratamento adequado
        echo "Erro ao atualizar último acesso: " . $e->getMessage();
    } finally {
        // Fecha a conexão com o banco de dados
        $conn = null;
    }
} else {
    // Redireciona para a página de login se o usuário não estiver logado
    header("Location: ../../index.php");
    exit;
}
?>
