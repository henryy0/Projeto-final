<?php
// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifica se todos os campos do formulário estão presentes
    if (isset($_POST['nomeProjeto']) && isset($_POST['tipoProjeto']) && isset($_POST['dataInicio']) && isset($_POST['dataFim']) && isset($_POST['resumoProjeto']) && isset($_POST['riscosProjeto']) && isset($_POST['orcamentoProjeto']) && isset($_POST['recursosProjeto'])) {
        
        // Conexão com o banco de dados
        $servername = "localhost";
        $username = "root"; // Insira seu usuário do banco de dados aqui
        $password = ""; // Insira sua senha do banco de dados aqui
        $dbname = "SistemaDeGerenciamento"; // Insira o nome do seu banco de dados aqui

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica se a conexão foi estabelecida com sucesso
        if ($conn->connect_error) {
            die("Falha na conexão com o banco de dados: " . $conn->connect_error);
        }

        // Prepara os dados para inserção no banco de dados (não esqueça de validar e filtrar os dados do formulário para evitar injeção de SQL)
        $nomeProjeto = $_POST['nomeProjeto'];
        $tipoProjeto = $_POST['tipoProjeto'];
        $dataInicio = $_POST['dataInicio'];
        $dataFim = $_POST['dataFim'];
        $resumoProjeto = $_POST['resumoProjeto'];
        $riscosProjeto = $_POST['riscosProjeto'];
        $orcamentoProjeto = $_POST['orcamentoProjeto'];
        $recursosProjeto = $_POST['recursosProjeto'];

        // Query SQL para inserir os dados do projeto no banco de dados
        $sql = "INSERT INTO Projeto (Nome_Projeto, Tipo_Projeto, Data_inicio_Projeto, Data_Fim_Projeto, Resumo_Projeto, Riscos_Projeto, Orcamento_Projeto, Recursos_Projeto)
                VALUES ('$nomeProjeto', '$tipoProjeto', '$dataInicio', '$dataFim', '$resumoProjeto', '$riscosProjeto', '$orcamentoProjeto', '$recursosProjeto')";

        if ($conn->query($sql) === TRUE) {
            header("Location: projetos.php");
        } else {
            echo "Erro ao adicionar o projeto: " . $conn->error;
        }

        // Fecha a conexão com o banco de dados
        $conn->close();
    } else {
        echo "Por favor, preencha todos os campos do formulário.";
    }
}
?>
