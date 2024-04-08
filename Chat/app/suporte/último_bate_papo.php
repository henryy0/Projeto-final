<?php 

function lastChat($id_1, $id_2, $conn){
   
   $sql = "SELECT * FROM Mensagens
           WHERE (de_id=? AND para_id=?)
           OR    (para_id=? AND de_id=?)
           ORDER BY id_mensagem DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id_1, $id_2, $id_1, $id_2]);

    if ($stmt->rowCount() > 0) {
    	$chat = $stmt->fetch();
    	return $chat['mensagem'];
    }else {
    	$chat = '';
    	return $chat;
    }

}
?>
