<?php
// Require do arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Verifica se os dados foram recebidos via POST
if (isset($_POST['title'], $_POST['start'], $_POST['end'])) {
    // Captura os valores recebidos
    $title = $_POST['title'];
    $start = $_POST['start'];
    $end = $_POST['end'];

    // Prepara e executa a inserção dos dados na tabela Calendario
    $sql = "INSERT INTO Calendario (titulo, inicio, fim) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $title, $start, $end);
    if ($stmt->execute()) {
        echo "Dados inseridos com sucesso.";
    } else {
        echo "Erro ao inserir dados: " . $stmt->error;
    }
} else {
    // Caso algum dos dados esteja ausente
    echo "Erro: dados incompletos.";
}
?>
