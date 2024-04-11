<?php
// Verifica se o ID foi recebido via POST
if (isset($_POST['id'])) {
    // Captura o ID recebido
    $id = $_POST['id'];

    // Inclui o arquivo de conexão com o banco de dados
    require_once '../includes/db.php';

    try {
        // Prepara a consulta SQL para deletar o evento com o ID fornecido
        $sql = "DELETE FROM Calendario WHERE id_calendario = ?";
        $stmt = $conn->prepare($sql); // Usando a variável $conn em vez de $bdd
        
        // Associa o parâmetro ao valor do ID
        $stmt->bind_param('i', $id);
        
        // Executa a consulta
        $stmt->execute();

        // Verifica se a consulta foi executada com sucesso
        if ($stmt->affected_rows > 0) {
            echo "Evento deletado com sucesso.";
        } else {
            echo "Nenhum evento encontrado com o ID fornecido.";
        }
    } catch (Exception $e) {
        echo "Erro ao executar a consulta: " . $e->getMessage();
    }
} else {
    // Caso o ID não tenha sido recebido via POST
    echo "Erro: ID do evento não fornecido.";
}
?>
