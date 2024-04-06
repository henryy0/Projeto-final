<?php
require_once '../includes/db.php'; // Inclua o arquivo de conexão com o banco de dados

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o ID da tarefa a ser pausada foi enviado via POST
    if (isset($_POST["idTarefaPausar"])) {
        $idTarefa = $_POST["idTarefaPausar"];

        // Verifique se a tarefa já possui um status
        $sqlVerificar = "SELECT Status_tarefa FROM Tarefa WHERE ID_tarefa = $idTarefa";
        $resultVerificar = $conn->query($sqlVerificar);

        if ($resultVerificar->num_rows > 0) {
            // A tarefa já possui um status, então atualize-o para "Pausado"
            $sql = "UPDATE Tarefa SET Status_tarefa = 'Pausado' WHERE ID_tarefa = $idTarefa";

            if ($conn->query($sql) === TRUE) {
                // Redirecione de volta para a página de tarefas após pausar a tarefa
                header("Location: tarefas.php");
                exit();
            } else {
                echo "Erro ao pausar a tarefa: " . $conn->error;
            }
        } else {
            // A tarefa ainda não possui um status, insira-a com o status "Pausado"
            $sqlInsert = "INSERT INTO Tarefa (ID_tarefa, Status_tarefa) VALUES ($idTarefa, 'Pausado')";

            if ($conn->query($sqlInsert) === TRUE) {
                // Redirecione de volta para a página de tarefas após pausar a tarefa
                header("Location: tarefas.php");
                exit();
            } else {
                echo "Erro ao pausar a tarefa: " . $conn->error;
            }
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
