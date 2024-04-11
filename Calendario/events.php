<?php
// Inclui o arquivo de configuração do banco de dados
require_once '../includes/db.php';

try {
    // Consulta SQL para recuperar os eventos
    $request = "SELECT id_calendario AS id, titulo AS title, inicio AS start, fim AS end FROM Calendario ORDER BY id_calendario";

    // Executa a consulta
    $result = $conn->query($request);

    // Verifica se a consulta foi bem-sucedida
    if ($result) {
        // Array para armazenar os eventos
        $events = array();

        // Loop através dos resultados e adiciona os eventos ao array
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }

        // Envia o resultado codificado em JSON
        echo json_encode($events);
    } else {
        // Em caso de falha na consulta, exibe uma mensagem de erro
        echo "Erro ao recuperar eventos do banco de dados.";
    }
} catch (Exception $e) {
    // Em caso de exceção, exibe uma mensagem de erro
    echo "Erro ao recuperar eventos do banco de dados: " . $e->getMessage();
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
