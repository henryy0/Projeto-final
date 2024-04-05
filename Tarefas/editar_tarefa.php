<?php
// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se o ID da tarefa foi enviado corretamente
    if (isset($_POST["idTarefaEditar"]) && !empty($_POST["idTarefaEditar"])) {
        // Captura os dados enviados pelo formulário
        $idTarefa = $_POST["idTarefaEditar"];
        $nomeTarefa = $_POST["nomeTarefaEditar"];
        $dataInicio = $_POST["dataInicioEditar"];
        $dataFim = $_POST["dataFimEditar"];
        $descricaoTarefa = $_POST["descricaoTarefaEditar"];
        $responsavelTarefa = $_POST["responsavelTarefaEditar"];

        // Aqui você deve incluir o arquivo de conexão com o banco de dados
        require_once '../includes/db.php';

        // Verifica se a conexão foi estabelecida corretamente
        if ($conexao) {
            // Query SQL para atualizar a tarefa no banco de dados
            $sql = "UPDATE Tarefa SET Nome_Tarefa=?, Data_Inicio_Tarefa=?, Data_Fim_Tarefa=?, Descricao_Tarefa=?, Responsavel_Tarefa=? WHERE ID_Tarefa=?";

            // Prepara a declaração SQL
            $stmt = mysqli_prepare($conexao, $sql);

            // Verifica se a declaração SQL foi preparada corretamente
            if ($stmt) {
                // Associa os parâmetros com a declaração SQL
                mysqli_stmt_bind_param($stmt, "ssssii", $nomeTarefa, $dataInicio, $dataFim, $descricaoTarefa, $responsavelTarefa, $idTarefa);

                // Executa a declaração SQL
                if (mysqli_stmt_execute($stmt)) {
                    // Redireciona de volta para a página de tarefas após a edição
                    header("Location: tarefas.php");
                    exit();
                } else {
                    // Exibe uma mensagem de erro em caso de falha na execução da declaração SQL
                    echo "Erro ao atualizar a tarefa: " . mysqli_error($conexao);
                }

                // Fecha a declaração
                mysqli_stmt_close($stmt);
            } else {
                // Exibe uma mensagem de erro em caso de falha na preparação da declaração SQL
                echo "Erro ao preparar a declaração SQL: " . mysqli_error($conexao);
            }

            // Fecha a conexão com o banco de dados
            mysqli_close($conexao);
        } else {
            // Exibe uma mensagem de erro caso a conexão não seja estabelecida corretamente
            echo "Erro ao conectar ao banco de dados";
        }
    } else {
        // Exibe uma mensagem de erro caso o ID da tarefa não seja enviado corretamente
        echo "ID da tarefa não especificado";
    }
} else {
    // Exibe uma mensagem de erro caso o formulário não tenha sido submetido
    echo "O formulário não foi submetido";
}
?>
