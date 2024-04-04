<?php
// Inclua o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Verifique se o ID do projeto foi enviado via POST
if(isset($_POST['idProjetoExcluir'])) {
    $id_projeto = $_POST['idProjetoExcluir'];

    // Query para excluir o projeto e suas tarefas associadas
    $sql_excluir_tarefas = "DELETE FROM Tarefa WHERE Projeto_tarefa = ?";
    $sql_excluir_projeto = "DELETE FROM Projeto WHERE ID_Projeto = ?";

    // Preparar e executar a declaração preparada para excluir tarefas
    $stmt_tarefas = $conn->prepare($sql_excluir_tarefas);
    $stmt_tarefas->bind_param('i', $id_projeto); // 'i' indica que o parâmetro é um inteiro
    $stmt_tarefas->execute();

    // Verificar se ocorreu algum erro ao executar a declaração preparada
    if ($stmt_tarefas->errno) {
        echo "Erro ao excluir tarefas: " . $stmt_tarefas->error;
        exit();
    }

    // Preparar e executar a declaração preparada para excluir o projeto
    $stmt_projeto = $conn->prepare($sql_excluir_projeto);
    $stmt_projeto->bind_param('i', $id_projeto); // 'i' indica que o parâmetro é um inteiro
    $stmt_projeto->execute();

    // Verificar se ocorreu algum erro ao executar a declaração preparada
    if ($stmt_projeto->errno) {
        echo "Erro ao excluir projeto: " . $stmt_projeto->error;
        exit();
    }

    // Verificar se as operações foram bem-sucedidas
    if ($stmt_tarefas->affected_rows > 0 && $stmt_projeto->affected_rows > 0) {
        // Projeto e tarefas excluídas com sucesso
        // Redirecionar para a página de projetos
        header("Location: projetos.php");
        exit();
    } else {
        // Se não houve linhas afetadas
        echo "Nenhum projeto ou tarefa encontrada para exclusão.";
    }

    // Fechar as declarações preparadas
    $stmt_tarefas->close();
    $stmt_projeto->close();
} else {
    // Se o ID do projeto não foi enviado via POST
    echo "ID do projeto não fornecido.";
}

// Fechar conexão com o banco de dados
$conn->close();
?>
