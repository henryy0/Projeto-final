<?php 

function opened($id_1, $conn, $chats){
    foreach ($chats as $chat) {
    	if ($chat['visualizada'] == 0) {
    		$opened = 1;
    		$chat_id = $chat['id_mensagem'];

    		$sql = "UPDATE Mensagens
    		        SET   visualizada = ?
    		        WHERE de_id=? 
    		        AND   id_mensagem = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$opened, $id_1, $chat_id]);

    	}
    }
}
?>
