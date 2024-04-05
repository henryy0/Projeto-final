<?php
// Inclua o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Verifique se o ID do projeto foi enviado via POST
if(isset($_POST['idProjetoPausar'])) {
    $id_projeto = $_POST['idProjetoPausar'];

    // Consulta para verificar se o projeto já tem um status definido
    $sql_verificar_status = "SELECT Status_Projeto FROM Projeto WHERE ID_Projeto = ?";
    
    // Preparar e executar a declaração preparada para verificar o status
    $stmt_verificar_status = $conn->prepare($sql_verificar_status);
    $stmt_verificar_status->bind_param('i', $id_projeto); // 'i' indica que o parâmetro é um inteiro
    $stmt_verificar_status->execute();
    $stmt_verificar_status->store_result();

    // Verificar se o projeto já tem um status definido
    if ($stmt_verificar_status->num_rows > 0) {
        // O projeto já tem um status definido, então atualizaremos para 'pausado'
        $sql_atualizar_status = "UPDATE Projeto SET Status_Projeto = 'Pausado' WHERE ID_Projeto = ?";
        
        // Preparar e executar a declaração preparada para atualizar o status
        $stmt_atualizar_status = $conn->prepare($sql_atualizar_status);
        $stmt_atualizar_status->bind_param('i', $id_projeto); // 'i' indica que o parâmetro é um inteiro
        $stmt_atualizar_status->execute();
        
        // Verificar se a atualização foi bem-sucedida
        if ($stmt_atualizar_status->affected_rows > 0) {
            echo "Status do projeto atualizado para 'Pausado' com sucesso.";
            // Redirecionar para a página projetos.php
            header("Location: projetos.php");
            exit();
        } else {
            echo "Erro ao atualizar o status do projeto para 'Pausado'.";
        }
        
        // Fechar declarações preparadas
        $stmt_atualizar_status->close();
    } else {
        // O projeto ainda não tem um status definido, então faremos uma inserção
        $sql_inserir_status = "INSERT INTO Projeto (ID_Projeto, Status_Projeto) VALUES (?, 'Pausado')";
        
        // Preparar e executar a declaração preparada para inserir o status
        $stmt_inserir_status = $conn->prepare($sql_inserir_status);
        $stmt_inserir_status->bind_param('i', $id_projeto); // 'i' indica que o parâmetro é um inteiro
        $stmt_inserir_status->execute();
        
        // Verificar se a inserção foi bem-sucedida
        if ($stmt_inserir_status->affected_rows > 0) {
            echo "Status 'Pausado' adicionado ao projeto com sucesso.";
            // Redirecionar para a página projetos.php
            header("Location: projetos.php");
            exit();
        } else {
            echo "Erro ao adicionar o status 'Pausado' ao projeto.";
        }
        
        // Fechar declarações preparadas
        $stmt_inserir_status->close();
    }
    
    // Fechar declarações preparadas
    $stmt_verificar_status->close();
} else {
    // Se o ID do projeto não foi enviado via POST
    echo "ID do projeto não fornecido.";
}

// Fechar conexão com o banco de dados
$conn->close();
?>
