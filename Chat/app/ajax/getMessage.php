<?php
session_start();

# Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {

    if (isset($_POST['id_2'])) {
        
        # Inclui o arquivo de conexão com o banco de dados
        include '../../../includes/db.php';

        if ($conn) {
            $id_1  = $_SESSION['id_usuario'];
            $id_2  = $_POST['id_2'];
            $opened = 0;

            $sql = "SELECT * FROM Mensagens
                    WHERE de_id = ?
                    AND   para_id = ?
                    ORDER BY id_mensagem ASC"; // Ordering by id_mensagem
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $id_1, $id_2); // Bind parameters
            $stmt->execute();
            $result = $stmt->get_result(); // Get result set

            // Check if there are rows returned
            if ($result->num_rows > 0) {
                // Fetch each row
                while ($chat = $result->fetch_assoc()) {
                    if ($chat['visualizada'] == 0) {
                        
                        $opened = 1;
                        $chat_id = $chat['id_mensagem']; // Correcting the column name

                        $sql2 = "UPDATE Mensagens
                                 SET visualizada = ?
                                 WHERE id_mensagem = ?"; // Correcting the table name and column name
                        $stmt2 = $conn->prepare($sql2);
                        $stmt2->bind_param("ii", $opened, $chat_id); // Bind parameters
                        $stmt2->execute(); 

                        # Display the message
                        ?>
                        <p class="ltext border rounded p-2 mb-1">
                            <?php echo htmlspecialchars($chat['mensagem']); ?> 
                            <small class="d-block">
                                <?php echo htmlspecialchars($chat['criado_em']); ?>
                            </small>          
                        </p>        
                        <?php
                    }
                }
            }
        } else {
            echo "Failed to connect to the database.";
        }

    }

} else {
    header("Location: ../../../index.php");
    exit;
}
?>
