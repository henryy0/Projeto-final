<?php
// Verificar se o ID da equipe foi enviado via POST
if (isset($_POST['idEquipeExcluir'])) {
    // Incluir arquivo de conexão com o banco de dados
    require_once('../includes/db.php');

    // Obter o ID da equipe a ser excluída
    $equipe_id = $_POST['idEquipeExcluir'];

    // Consulta SQL para excluir a equipe da tabela Equipe
    $sql_delete_equipe = "DELETE FROM Equipe WHERE equipe_id = $equipe_id";

    // Consulta SQL para excluir os registros da tabela Equipe_Membro relacionados à equipe
    $sql_delete_equipe_membro = "DELETE FROM Equipe_Membro WHERE equipe_id = $equipe_id";

    // Executar as consultas SQL
    if ($conn->query($sql_delete_equipe) === TRUE && $conn->query($sql_delete_equipe_membro) === TRUE) {
        // Equipe excluída com sucesso
        header("Location: equipe.php");
    } else {
        // Se houver erro na exclusão da equipe
        echo "Erro ao excluir equipe: " . $conn->error;
    }

    // Fechar conexão com o banco de dados
    $conn->close();
} else {
    // Se o ID da equipe não foi enviado via POST
    echo "ID da equipe não fornecido.";
}
?>
