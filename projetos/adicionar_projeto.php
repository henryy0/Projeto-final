<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão presentes
    if (isset($_POST['nomeProjeto']) && isset($_POST['tipoProjeto']) && isset($_POST['dataInicio']) && isset($_POST['dataFim']) && isset($_POST['resumoProjeto']) && isset($_POST['riscosProjeto']) && isset($_POST['orcamentoProjeto']) && isset($_POST['recursosProjeto'])) {
        
        // Inclui o arquivo de conexão com o banco de dados
        require_once '../includes/db.php';

        // Prepara os dados para inserção no banco de dados (não esqueça de validar e filtrar os dados do formulário para evitar injeção de SQL)
        $nomeProjeto = $_POST['nomeProjeto'];
        $tipoProjeto = $_POST['tipoProjeto'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
        $resumoProjeto = $_POST['resumoProjeto'];
        $riscosProjeto = $_POST['riscosProjeto'];
        $orcamentoProjeto = $_POST['orcamentoProjeto'];
        $recursosProjeto = $_POST['recursosProjeto'];

        // Definindo o status como "Em Andamento"
        $status = "Em Andamento";

        // Query SQL para verificar se o nome do projeto já existe
        $check_sql = "SELECT Nome_Projeto FROM Projeto WHERE Nome_Projeto = '$nomeProjeto'";
        $result = $conn->query($check_sql);

        // Verifica se o resultado possui pelo menos uma linha, o que significa que o nome do projeto já existe
        if ($result->num_rows > 0) {
            echo "Já existe um projeto com esse nome. Por favor, escolha um nome diferente.";
        } else {
            // Se o nome do projeto não existir, proceda com a inserção
            $sql = "INSERT INTO Projeto (Nome_Projeto, Tipo_Projeto, Data_inicio_Projeto, Data_Fim_Projeto, Resumo_Projeto, Riscos_Projeto, Orcamento_Projeto, Recursos_Projeto, Status_Projeto)
                    VALUES ('$nomeProjeto', '$tipoProjeto', '$dataInicio', '$dataFim', '$resumoProjeto', '$riscosProjeto', '$orcamentoProjeto', '$recursosProjeto', '$status')";
            
            if ($conn->query($sql) === TRUE) {
                header("Location: projetos.php");
            } else {
                echo "Erro ao adicionar o projeto: " . $conn->error;
            }
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
}
?>
