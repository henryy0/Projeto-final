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

    // Prepara a consulta SQL para inserir a nova tarefa
    $sql = "INSERT INTO Tarefa (Nome_tarefa, Data_inicio_Tarefa, Data_Fim_Tarefa, Obs_tarefa, Status_tarefa, Responsavel_tarefa) 
            VALUES (?, ?, ?, ?, ?, ?)";

    // Prepara a instrução SQL
    $stmt = mysqli_prepare($conexao, $sql);

    // Verifica se a preparação da consulta foi bem-sucedida
    if ($stmt) {
        // Define os parâmetros da consulta
        $statusTarefa = 'Em Andamento'; // Define o status da tarefa como 'Em Andamento' ao adicionar
        mysqli_stmt_bind_param($stmt, 'sssssi', $nomeTarefa, $dataInicio, $dataFim, $descricaoTarefa, $statusTarefa, $responsavelTarefa);

        // Executa a consulta
        if (mysqli_stmt_execute($stmt)) {
            // Redireciona o usuário de volta para a página de tarefas
            header("Location: tarefas.php");
            exit();
        } else {
            // Exibe uma mensagem de erro caso a execução da consulta falhe
            echo "Erro ao adicionar tarefa: " . mysqli_error($conexao);
        }

        // Fecha a instrução SQL
        mysqli_stmt_close($stmt);
    } else {
        // Exibe uma mensagem de erro caso a preparação da consulta falhe
        echo "Erro ao preparar a consulta: " . mysqli_error($conexao);
    }

    // Fecha a conexão com o banco de dados
    mysqli_close($conexao);
} else {
    // Se o formulário não foi submetido via POST, redireciona o usuário de volta para a página de tarefas
    header("Location: tarefas.php");
    exit();
}
?>
