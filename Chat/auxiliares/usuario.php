<?php  

function getUser($id_usuario, $conn){
    $sql = "SELECT * FROM Usuario 
            WHERE id_usuario=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_usuario); // Bind do parâmetro, assumindo que id_usuario é um inteiro
    $stmt->execute();
    $result = $stmt->get_result(); // Obter o resultado da consulta

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        return $user;
    } else {
        $user = [];
        return $user;
    }
}
?>
