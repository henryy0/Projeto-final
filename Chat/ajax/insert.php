<?php
session_start();

// Verifica se a requisição é do tipo POST e se o usuário está logado
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['id_usuario'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include '../../includes/db.php';

    // Verifica se os dados necessários foram recebidos via POST e se não estão vazios
    if (isset($_POST['texto_mensagem']) && isset($_POST['para_id']) && !empty($_POST['texto_mensagem']) && !empty($_POST['para_id'])) {
        // Obtém os dados da requisição
        $mensagem = htmlspecialchars($_POST['texto_mensagem']); // Sanitiza a mensagem para evitar XSS
        $de_id = $_SESSION['id_usuario'];
        $para_id = $_POST['para_id'];

        // Prepara e executa a query SQL para verificar se o usuário de destino existe no banco de dados
        $sql_verificar_usuario = "SELECT id_usuario FROM Usuario WHERE id_usuario = ?";
        $stmt_verificar_usuario = $conn->prepare($sql_verificar_usuario);
        $stmt_verificar_usuario->bind_param("i", $para_id);
        $stmt_verificar_usuario->execute();
        $result_verificar_usuario = $stmt_verificar_usuario->get_result();

        if ($result_verificar_usuario->num_rows > 0) {
            // Prepara e executa a query SQL para inserir a mensagem no banco de dados
            $sql_insert = "INSERT INTO Mensagens (de_id, para_id, mensagem) VALUES (?, ?, ?)";
            $stmt_insert = $conn->prepare($sql_insert);
            $stmt_insert->bind_param("iis", $de_id, $para_id, $mensagem);

            if ($stmt_insert->execute()) {
                // Se a inserção for bem-sucedida, retorna uma mensagem de sucesso
                echo json_encode(array("status" => "success", "message" => "Mensagem enviada com sucesso."));
            } else {
                // Se ocorrer um erro durante a inserção, retorna uma mensagem de erro detalhada
                echo json_encode(array("status" => "error", "message" => "Erro ao enviar a mensagem: " . $stmt_insert->error));
            }

            // Fecha o statement após a execução da query
            $stmt_insert->close();
        } else {
            // Se o usuário de destino não existir, retorna uma mensagem de erro
            echo json_encode(array("status" => "error", "message" => "Usuário de destino não encontrado."));
        }

        // Fecha o resultado e o statement após a execução da query
        $stmt_verificar_usuario->close();
        $result_verificar_usuario->close();
    } else {
        // Se os dados necessários não foram recebidos ou estão vazios, retorna uma mensagem de erro
        echo json_encode(array("status" => "error", "message" => "Parâmetros ausentes ou inválidos na requisição."));
    }
} else {
    // Se a requisição não for do tipo POST ou se o usuário não estiver logado, redireciona para a página de login
    header("Location: ../../index.php");
    exit;
}
?>
