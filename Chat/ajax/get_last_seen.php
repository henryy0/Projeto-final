<?php
// Verifica se a sessão não está definida e, em seguida, a inicia
if (!isset($_SESSION)) {
    session_start();
}

// Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    // Inclui o arquivo de conexão com o banco de dados
    include '../../includes/db.php';

    try {
        // Obtém o ID do usuário específico enviado por POST
        $recipient_id = $_POST['recipient_id'];

        // Prepara e executa a consulta para obter o último acesso do usuário específico
        $sql = "SELECT TIME(ultimo_acesso) AS horario FROM Usuario WHERE id_usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("i", $recipient_id);
        $stmt->execute();
        $result = $stmt->get_result();

        // Verifica se há resultados
        if ($result->num_rows > 0) {
            // Obtém a linha de resultado
            $row = $result->fetch_assoc();
            // Extrai o valor do horário do último acesso
            $horario_ultimo_acesso = $row['horario'];
            // Retorna o valor do horário do último acesso
            echo date_format(date_create($horario_ultimo_acesso), 'H:i:s');
        } else {
            // Se não houver resultados, retorna uma mensagem de erro ou vazio
            echo "Nenhum resultado";
        }

        // Fecha a conexão com o banco de dados
        $stmt->close();
        $conn->close();
    } catch (PDOException $e) {
        // Em caso de erro, exibe uma mensagem de erro ou faz o tratamento adequado
        echo "Erro ao obter horário do último acesso: " . $e->getMessage();
    }
} else {
    // Se o usuário não estiver logado, retorna uma mensagem de erro
    echo "Usuário não logado";
}
?>
