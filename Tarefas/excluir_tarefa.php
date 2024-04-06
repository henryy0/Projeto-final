<?php
// Verifica se o ID da tarefa foi enviado via POST
if(isset($_POST['idTarefaExcluir'])) {
    // Inclui o arquivo de conexão com o banco de dados
    require_once '../includes/db.php';

    // Obtém o ID da tarefa a ser excluída
    $idTarefa = $_POST['idTarefaExcluir'];

    // Prepara a consulta SQL para excluir a tarefa
    $sql = "DELETE FROM Tarefa WHERE ID_tarefa = ?";

    // Prepara a instrução SQL
    $stmt = $conn->prepare($sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        // Define o parâmetro da consulta
        $stmt->bind_param('i', $idTarefa);

        // Executa a consulta
        if ($stmt->execute()) {
            // Redireciona o usuário de volta para a página de tarefas
            header("Location: tarefas.php");
            exit();
        } else {
            // Exibe uma mensagem de erro caso a execução da consulta falhe
            echo "Erro ao excluir tarefa: " . $conn->error;
        }

        // Fecha a instrução SQL
        $stmt->close();
    } else {
        // Exibe uma mensagem de erro caso a preparação da consulta falhe
        echo "Erro ao preparar a consulta: " . $conn->error;
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
} else {
    // Se o ID da tarefa não foi enviado via POST, redireciona o usuário de volta para a página de tarefas
    header("Location: tarefas.php");
    exit();
}
?>
