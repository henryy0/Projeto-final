<?php 
function getConversation($id_1, $id_2, $conn){
    $sql = "SELECT * FROM Mensagens
            WHERE (de_id=? AND para_id=?)
            OR    (para_id=? AND de_id=?)
            ORDER BY id_mensagem ASC"; // Corrigindo para ordenar pelo ID da mensagem
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $id_1, $id_2, $id_2, $id_1); // Corrigindo a ordem dos parâmetros e usando bind_param para evitar SQL injection
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }

    return $messages;
}
?>
