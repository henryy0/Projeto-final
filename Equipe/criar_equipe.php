<?php
// Verificar se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir arquivo de conexão com o banco de dados
    require_once('../includes/db.php');

    // Receber os dados do formulário
    $data = [
        'nomeEquipe' => $_POST['nomeEquipe'],
        'descricaoEquipe' => $_POST['descricaoEquipe'],
        'liderEquipe' => $_POST['liderEquipe'],
        'membrosEquipe' => isset($_POST['membrosEquipe']) ? $_POST['membrosEquipe'] : [],
        'projetosEquipe' => isset($_POST['projetosEquipe']) ? $_POST['projetosEquipe'] : []
    ];

    // Preparar e executar a consulta SQL para inserir a equipe
    $sql_equipe = "INSERT INTO Equipe (equipe_nome, equipe_descricao, equipe_lider_id) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql_equipe);
    $stmt->bind_param("ssi", $data['nomeEquipe'], $data['descricaoEquipe'], $data['liderEquipe']);
    if ($stmt->execute()) {
        $equipe_id = $conn->insert_id; // ID da equipe recém-inserida

        // Fetch the leader's email
        $sql_leader_email = "SELECT email_usuario FROM Usuario WHERE id_usuario = ?";
        $stmt_leader_email = $conn->prepare($sql_leader_email);
        $stmt_leader_email->bind_param("i", $data['liderEquipe']);
        if ($stmt_leader_email->execute()) {
            $result_leader_email = $stmt_leader_email->get_result();
            if ($row = $result_leader_email->fetch_assoc()) {
                $leader_email = $row['email_usuario'];

                // Update the leader's email in the team
                $sql_update_leader_email = "UPDATE Equipe SET lider_email = ? WHERE equipe_id = ?";
                $stmt_update_leader_email = $conn->prepare($sql_update_leader_email);
                $stmt_update_leader_email->bind_param("si", $leader_email, $equipe_id);
                if (!$stmt_update_leader_email->execute()) {
                    echo "Erro ao atualizar o email do líder na equipe: " . $stmt_update_leader_email->error;
                }
            } else {
                echo "Erro ao obter o email do líder.";
            }
        }

        // Inserir os membros da equipe na tabela de relacionamento
        foreach ($data['membrosEquipe'] as $membro_id) {
            $sql_membro = "INSERT INTO Equipe_Membro (equipe_id, usuario_id) VALUES (?, ?)";
            $stmt_membro = $conn->prepare($sql_membro);
            $stmt_membro->bind_param("ii", $equipe_id, $membro_id);
            $stmt_membro->execute();
        }

        // Inserir os projetos atribuídos à equipe na tabela de relacionamento
        foreach ($data['projetosEquipe'] as $projeto_id) {
            $sql_projeto = "INSERT INTO Equipe_Projeto (equipe_id, projeto_id) VALUES (?, ?)";
            $stmt_projeto = $conn->prepare($sql_projeto);
            $stmt_projeto->bind_param("ii", $equipe_id, $projeto_id);
            if (!$stmt_projeto->execute()) {
                echo "Erro ao atribuir projeto à equipe: " . $stmt_projeto->error;
            }
        }

        header("Location: equipe.php");
    } else {
        echo "Erro ao criar equipe: " . $stmt->error;
    }

    // Fechar as declarações preparadas
    $stmt->close();
    $stmt_leader_email->close();
    $stmt_update_leader_email->close();
    $stmt_membro->close();
    $stmt_projeto->close();

    // Fechar conexão com o banco de dados
    $conn->close();
} else {
    // Redirecionar para a página de criação de equipe se o formulário não foi submetido
    header("Location: equipe.php");
    exit();
}
?>
