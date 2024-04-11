<?php
// Verificar se o formulário foi enviado usando o método POST
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Incluir o arquivo para conectar ao banco de dados
    require_once('../includes/db.php');

    // Verificar se todos os campos obrigatórios estão presentes nos dados POST
    if (isset($_POST['nomeMembro'], $_POST['equipeMembro'])) {
        // Obter os dados do formulário
        $idMembro = $_POST['nomeMembro']; // Supondo que $idMembro seja o ID do usuário
        $equipeMembro = $_POST['equipeMembro'];
        
        // Verificar se o ID do membro e o ID da equipe não estão vazios
        if (!empty($equipeMembro) && !empty($idMembro)) {
            // Verificar se o membro já está na equipe
            $sql_check_member = "SELECT COUNT(*) AS total FROM Equipe_Membro WHERE equipe_id = ? AND usuario_id = ?";
            $stmt_check_member = $conn->prepare($sql_check_member);
            $stmt_check_member->bind_param("ii", $equipeMembro, $idMembro);
            $stmt_check_member->execute();
            $result_check_member = $stmt_check_member->get_result();
            
            if ($result_check_member) {
                $row = $result_check_member->fetch_assoc();
                if ($row['total'] > 0) {
                    // O membro já está na equipe
                    echo "O membro já está na equipe.";
                } else {
                    // Adicionar o membro à equipe
                    $sql_add_member = "INSERT INTO Equipe_Membro (equipe_id, usuario_id) VALUES (?, ?)";
                    $stmt_add_member = $conn->prepare($sql_add_member);
                    $stmt_add_member->bind_param("ii", $equipeMembro, $idMembro);
                    if ($stmt_add_member->execute()) {
                        // Membro adicionado com sucesso
                        // Redirecionar para equipe.php
                        header("Location: equipe.php");
                        exit(); // Certificar-se de sair após o redirecionamento
                    } else {
                        // Se houver um erro ao adicionar o membro à equipe
                        echo "Erro ao adicionar membro à equipe: " . $stmt_add_member->error;
                    }
                    // Fechar a declaração preparada
                    $stmt_add_member->close();
                }
            } else {
                // Se houver um erro na consulta
                echo "Erro ao verificar o membro na equipe.";
            }
            // Fechar a declaração preparada
            $stmt_check_member->close();
        } else {
            echo "O usuário ou equipe não foram selecionados.";
        }
    } else {
        // Se algum dos campos obrigatórios não foi enviado
        echo "Todos os campos são obrigatórios.";
    }

    // Fechar a conexão com o banco de dados
    $conn->close();
} else {
    // Se o formulário não foi enviado usando o método POST
    echo "O formulário não foi enviado corretamente.";
}
?>
