<?php
require_once '../includes/db.php'; // Inclua o arquivo de conexão com o banco de dados

// Função para calcular a porcentagem de conclusão de um projeto com base nas tarefas concluídas
function calcularPorcentagemConclusaoDoProjeto($idProjeto) {
    global $conn;

    // Consulta para obter o número total de tarefas do projeto
    $sqlTotalTarefas = "SELECT COUNT(*) AS total FROM Tarefa WHERE Projeto_tarefa = $idProjeto";
    $resultTotalTarefas = $conn->query($sqlTotalTarefas);
    $rowTotalTarefas = $resultTotalTarefas->fetch_assoc();
    $totalTarefas = $rowTotalTarefas['total'];

    // Consulta para obter o número de tarefas concluídas do projeto
    $sqlTarefasConcluidas = "SELECT COUNT(*) AS concluidas FROM Tarefa WHERE Projeto_tarefa = $idProjeto AND Status_tarefa = 'Concluído'";
    $resultTarefasConcluidas = $conn->query($sqlTarefasConcluidas);
    $rowTarefasConcluidas = $resultTarefasConcluidas->fetch_assoc();
    $tarefasConcluidas = $rowTarefasConcluidas['concluidas'];

    // Calcula a porcentagem de conclusão
    if ($totalTarefas > 0) {
        $porcentagemConclusao = ($tarefasConcluidas / $totalTarefas) * 100;
    } else {
        $porcentagemConclusao = 0;
    }

    return $porcentagemConclusao;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID da tarefa a ser concluída foi enviado via POST
    if (isset($_POST["idTarefaConcluir"])) {
        $idTarefa = $_POST["idTarefaConcluir"];

        // Atualize o status da tarefa para "Concluído" no banco de dados
        $sql = "UPDATE Tarefa SET Status_tarefa = 'Concluído' WHERE ID_tarefa = $idTarefa";

        if ($conn->query($sql) === TRUE) {
            // Obtenha o ID do projeto associado à tarefa concluída
            $sqlProjeto = "SELECT Projeto_tarefa FROM Tarefa WHERE ID_tarefa = $idTarefa";
            $resultProjeto = $conn->query($sqlProjeto);
            $rowProjeto = $resultProjeto->fetch_assoc();
            $idProjeto = $rowProjeto['Projeto_tarefa'];

            // Recalcule a porcentagem de conclusão do projeto
            $porcentagemConclusao = calcularPorcentagemConclusaoDoProjeto($idProjeto);

            // Atualize a porcentagem de conclusão do projeto no banco de dados
            $sqlUpdatePorcentagem = "UPDATE Projeto SET Porcentagem_Conclusao = $porcentagemConclusao WHERE ID_Projeto = $idProjeto";
            $conn->query($sqlUpdatePorcentagem);

            // Redirecione de volta para a página de tarefas após concluir a tarefa
            header("Location: tarefas.php");
            exit();
        } else {
            echo "Erro ao concluir a tarefa: " . $conn->error;
        }
    } else {
        echo "ID da tarefa não foi fornecido.";
    }
} else {
    echo "Método de requisição inválido.";
}

// Feche a conexão com o banco de dados
$conn->close();
?>
