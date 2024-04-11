<?php
// Verificar se o ID da equipe foi enviado via POST
if (isset($_POST['idEquipeExcluir'])) {
    // Incluir arquivo de conexão com o banco de dados
    require_once('../includes/db.php');

    // Obter o ID da equipe a ser excluída
    $equipe_id = $_POST['idEquipeExcluir'];

    // Consulta SQL para excluir os registros da tabela Equipe_Projeto relacionados à equipe
    $sql_delete_equipe_projeto = "DELETE FROM Equipe_Projeto WHERE equipe_id = $equipe_id";

    // Executar a consulta SQL para excluir os registros da tabela Equipe_Projeto
    if ($conn->query($sql_delete_equipe_projeto) === TRUE) {
        // Consulta SQL para excluir a equipe da tabela Equipe
        $sql_delete_equipe = "DELETE FROM Equipe WHERE equipe_id = $equipe_id";

        // Executar a consulta SQL para excluir a equipe
        if ($conn->query($sql_delete_equipe) === TRUE) {
            // Equipe excluída com sucesso
            header("Location: equipe.php");
        } else {
            // Se houver erro na exclusão da equipe
            echo "Erro ao excluir equipe: " . $conn->error;
        }
    } else {
        // Se houver erro na exclusão dos registros da tabela Equipe_Projeto
        echo "Erro ao excluir registros da tabela Equipe_Projeto: " . $conn->error;
    }

    // Fechar conexão com o banco de dados
    $conn->close();
} else {
    // Se o ID da equipe não foi enviado via POST
    echo "ID da equipe não fornecido.";
}
?>
