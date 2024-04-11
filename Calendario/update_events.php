<?php
// Valores recebidos via ajax
$id = $_POST['id'];
$title = $_POST['title'];
$start = $_POST['start'];
$end = $_POST['end'];

// Inclui o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

try {
    // Atualiza os registros
    $sql = "UPDATE Calendario SET titulo = ?, inicio = ?, fim = ? WHERE id_calendario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $title, $start, $end, $id);
    $stmt->execute();

    // Verifica se a atualização foi bem-sucedida
    if ($stmt->affected_rows > 0) {
        echo "Evento atualizado com sucesso!";
    } else {
        echo "Erro ao atualizar evento.";
    }
} catch (Exception $e) {
    // Trata erros de exceção
    echo "Erro ao executar a consulta: " . $e->getMessage();
}
?>
