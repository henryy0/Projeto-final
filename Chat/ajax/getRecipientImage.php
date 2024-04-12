<?php
// Verifica se o ID do destinatário foi enviado por POST
if(isset($_POST['recipient_id'])) {
    $recipientId = $_POST['recipient_id'];

    // Consulta ao banco de dados para obter o caminho da imagem do destinatário
    include '../../includes/db.php'; // Inclua seu arquivo de conexão com o banco de dados

    $sql = "SELECT foto_usuario FROM Usuario WHERE id_usuario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $recipientId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $caminho_imagem = "../img/usuarios/" . $recipientId . "/" . $row['foto_usuario'];
        
        // Retorna o caminho da imagem do destinatário
        echo $caminho_imagem;
    } else {
        // Se não houver imagem para o destinatário, retorne um valor padrão ou uma mensagem de erro
        echo "caminho/para/uma/imagem/default.jpg"; // Altere para o caminho da imagem padrão ou uma mensagem de erro apropriada
    }

    // Fecha a conexão com o banco de dados
    $stmt->close();
    $conn->close();
} else {
    // Se o ID do destinatário não foi enviado, exiba uma mensagem de erro
    echo "Erro: ID do destinatário não foi recebido.";
}
?>
