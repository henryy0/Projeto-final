<?php

session_start();

# Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {

    if (
        isset($_POST['texto_mensagem']) &&
        isset($_POST['para_id'])
    ) {

        # Inclui o arquivo de conexão com o banco de dados
        include '../includes/db.php';

        # Obtém dados da requisição XHR e armazena-os em variáveis
        $mensagem = $_POST['texto_mensagem'];
        $para_id = $_POST['para_id'];

        # Obtém o ID do usuário logado da SESSÃO
        $de_id = $_SESSION['id_usuario'];

        $sql = "INSERT INTO Mensagens (de_id, para_id, mensagem, criado_em) 
                VALUES (?, ?, ?, NOW())"; // Using NOW() to insert current timestamp
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $de_id, $para_id, $mensagem); // Binding parameters
        $res = $stmt->execute();

        # Se a mensagem for inserida com sucesso
        if ($res) {

            // Verifica se esta é a primeira conversa entre eles
            $sql2 = "SELECT * FROM Conversas
                     WHERE (usuario_1=? AND usuario_2=?)
                     OR    (usuario_2=? AND usuario_1=?)";
            $stmt2 = $conn->prepare($sql2);
            $stmt2->bind_param("iiii", $de_id, $para_id, $de_id, $para_id); // Binding parameters
            $stmt2->execute();

            $hora = date("h:i:s a");

            if ($stmt2->num_rows == 0) { // Using num_rows to check the number of rows returned
                # Insere-os na tabela Conversas
                $sql3 = "INSERT INTO Conversas (usuario_1, usuario_2, criado_em)
                         VALUES (?, ?, NOW())"; // Using NOW() to insert current timestamp
                $stmt3 = $conn->prepare($sql3);
                $stmt3->bind_param("ii", $de_id, $para_id); // Binding parameters
                $stmt3->execute();
            }
?>

            <p class="rtext align-self-end border rounded p-2 mb-1">
                <?= htmlspecialchars($mensagem) ?> <!-- Using htmlspecialchars to prevent XSS -->
                <small class="d-block"><?= $hora ?></small>
            </p>

<?php
        }
    }
} else {
    header("Location: ../../index.php");
    exit;
}
?>
