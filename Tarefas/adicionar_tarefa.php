<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Inclui o arquivo de conexão com o banco de dados
    require_once '../includes/db.php';

    // Captura os dados do formulário
    $nomeTarefa = $_POST['nomeTarefa'];
    $dataInicio = $_POST['dataInicio'];
    $dataFim = $_POST['dataFim'];
    $descricaoTarefa = $_POST['descricaoTarefa'];
    $responsavelTarefa = $_POST['responsavelTarefa'];
    $projetoTarefa = $_POST['projetoTarefa']; // Adiciona o projeto da tarefa

    // Prepara a consulta SQL para inserir a nova tarefa
    $sql = "INSERT INTO Tarefa (Nome_tarefa, Data_inicio_Tarefa, Data_Fim_Tarefa, Obs_tarefa, Status_tarefa, Responsavel_tarefa, Projeto_tarefa) 
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    // Prepara a instrução SQL
    $stmt = $conn->prepare($sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        // Define os parâmetros da consulta
        $statusTarefa = 'Em Andamento'; // Define o status da tarefa como 'Em Andamento' ao adicionar
        $stmt->bind_param('ssssiii', $nomeTarefa, $dataInicio, $dataFim, $descricaoTarefa, $statusTarefa, $responsavelTarefa, $projetoTarefa);

        // Executa a consulta
        if ($stmt->execute()) {
            // Redireciona o usuário de volta para a página de tarefas
            header("Location: tarefas.php");
            exit();
        } else {
            // Exibe uma mensagem de erro caso a execução da consulta falhe
            echo "Erro ao adicionar tarefa: " . $conn->error;
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
    // Se o formulário não foi submetido via POST, redireciona o usuário de volta para a página de tarefas
    header("Location: tarefas.php");
    exit();
}
?>
