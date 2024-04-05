<?php
// Incluir o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Verificar se os dados do projeto foram enviados via POST
if(isset($_POST['idProjetoEditar'], $_POST['nomeProjetoEditar'], $_POST['tipoProjetoEditar'], $_POST['dataInicioEditar'], $_POST['dataFimEditar'], $_POST['resumoProjetoEditar'], $_POST['riscosProjetoEditar'], $_POST['orcamentoProjetoEditar'], $_POST['recursosProjetoEditar'])) {
    // Obter os dados do formulário
    $id_projeto = $_POST['idProjetoEditar'];
    $nome_projeto = $_POST['nomeProjetoEditar'];
    $tipo_projeto = $_POST['tipoProjetoEditar'];
    $data_inicio = $_POST['dataInicioEditar'];
    $data_fim = $_POST['dataFimEditar'];
    $resumo_projeto = $_POST['resumoProjetoEditar'];
    $riscos_projeto = $_POST['riscosProjetoEditar'];
    $orcamento_projeto = $_POST['orcamentoProjetoEditar'];
    $recursos_projeto = $_POST['recursosProjetoEditar'];

    // Query para atualizar os dados do projeto
    $sql_atualizar_projeto = "UPDATE Projeto SET Nome_Projeto = ?, Tipo_Projeto = ?, Data_inicio_Projeto = ?, Data_Fim_Projeto = ?, Resumo_Projeto = ?, Riscos_Projeto = ?, Orcamento_Projeto = ?, Recursos_Projeto = ? WHERE ID_Projeto = ?";

    // Preparar e executar a declaração preparada para atualizar o projeto
    $stmt_atualizar_projeto = $conn->prepare($sql_atualizar_projeto);
    $stmt_atualizar_projeto->bind_param('ssssssdii', $nome_projeto, $tipo_projeto, $data_inicio, $data_fim, $resumo_projeto, $riscos_projeto, $orcamento_projeto, $recursos_projeto, $id_projeto); // 'ssssssdii' indica que os parâmetros são strings e um double, respectivamente
    $stmt_atualizar_projeto->execute();

    // Verificar se a atualização foi bem-sucedida
    if ($stmt_atualizar_projeto->affected_rows > 0) {
        // Redirecionar de volta para a página de projetos após a atualização do projeto
        header("Location: projetos.php");
        exit(); // Encerrar o script após o redirecionamento
    } else {
        echo "Erro ao atualizar o projeto.";
    }

    // Fechar declaração preparada
    $stmt_atualizar_projeto->close();
} else {
    // Se os dados do projeto não foram enviados via POST
    echo "Dados do projeto não fornecidos.";
}

// Fechar conexão com o banco de dados
$conn->close();
?>
