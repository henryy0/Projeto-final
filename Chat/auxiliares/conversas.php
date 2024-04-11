<?php 

function getConversation($user_id, $conn){
    // Obtendo todas as conversas para o usuário atual (logado)
    $sql = "SELECT * FROM Conversas
            WHERE usuario_1=? OR usuario_2=?
            ORDER BY id_conversa DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute([$user_id, $user_id]);

    // Verificando se existem conversas
    if($stmt->rowCount() > 0){
        $conversations = $stmt->fetchAll();
        $user_data = [];

        // Looping através das conversas
        foreach($conversations as $conversation){
            // Determinando o ID do outro usuário na conversa
            $other_user_id = ($conversation['usuario_1'] == $user_id) ? $conversation['usuario_2'] : $conversation['usuario_1'];
            
            // Obtendo os detalhes do outro usuário na conversa
            $sql2 = "SELECT * FROM Usuario WHERE id_usuario=?";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->execute([$other_user_id]);
            $other_user_data = $stmt2->fetch();

            // Verificando se os detalhes do usuário foram encontrados
            if($other_user_data){
                // Adicionando os detalhes do usuário ao array de conversas
                $user_data[] = $other_user_data;
            }
        }

        return $user_data;
    } else {
        return []; // Retorna um array vazio se não houver conversas
    }
}
?>
