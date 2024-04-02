<?php
// Incluir arquivo de configuração do banco de dados
require_once '../includes/db.php';

// Verificar se a solicitação é do tipo POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Decodificar os dados JSON recebidos
    $data = json_decode(file_get_contents("php://input"));

    // Verificar o tipo de solicitação
    if ($data->request_type == 'addEvent') {
        // Extrair os dados do evento
        $titulo = $data->event_data[0];
        $descricao = $data->event_data[1];
        $url = $data->event_data[2];
        $inicio = $data->start;
        $fim = $data->end;

        // Preparar e executar a consulta SQL para adicionar o evento
        $stmt = $mysqli->prepare("INSERT INTO calendario (titulo, descricao, url, inicio, fim) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $titulo, $descricao, $url, $inicio, $fim);
        $result = $stmt->execute();

        // Verificar se a inserção foi bem-sucedida
        if ($result) {
            echo json_encode(array("status" => 1));
        } else {
            echo json_encode(array("error" => "Falha ao adicionar o evento."));
        }
    } elseif ($data->request_type == 'editEvent') {
        // Extrair os dados do evento
        $titulo = $data->event_data[0];
        $descricao = $data->event_data[1];
        $url = $data->event_data[2];
        $inicio = $data->start;
        $fim = $data->end;
        $id = $data->event_id;

        // Preparar e executar a consulta SQL para editar o evento
        $stmt = $mysqli->prepare("UPDATE calendario SET titulo=?, descricao=?, url=?, inicio=?, fim=? WHERE id=?");
        $stmt->bind_param("sssssi", $titulo, $descricao, $url, $inicio, $fim, $id);
        $result = $stmt->execute();

        // Verificar se a atualização foi bem-sucedida
        if ($result) {
            echo json_encode(array("status" => 1));
        } else {
            echo json_encode(array("error" => "Falha ao editar o evento."));
        }
    } elseif ($data->request_type == 'deleteEvent') {
        // Extrair o ID do evento
        $id = $data->event_id;

        // Preparar e executar a consulta SQL para excluir o evento
        $stmt = $mysqli->prepare("DELETE FROM calendario WHERE id=?");
        $stmt->bind_param("i", $id);
        $result = $stmt->execute();

        // Verificar se a exclusão foi bem-sucedida
        if ($result) {
            echo json_encode(array("status" => 1));
        } else {
            echo json_encode(array("error" => "Falha ao excluir o evento."));
        }
    }
}

// Fechar conexão com o banco de dados
$mysqli->close();
?>
