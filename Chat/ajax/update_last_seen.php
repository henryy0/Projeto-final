<?php
// Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include '../../includes/db.php';

    try {
        // Obtém o ID do usuário logado da SESSÃO
        $id_usuario = $_SESSION['id_usuario'];

        // Prepara a consulta para recuperar o último acesso do usuário
        $sql = "SELECT ultimo_acesso FROM Usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $id_usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Recupera o último acesso do resultado da consulta
            $row = $result->fetch_assoc();
            $ultimo_acesso = $row['ultimo_acesso'];

            // Exibe o último acesso na interface do usuário
            echo "Último Acesso: " . $ultimo_acesso;
        } else {
            echo "Nenhum resultado encontrado";
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro ou faz o tratamento adequado
        echo "Erro ao recuperar último acesso: " . $e->getMessage();
    }
}
?>
