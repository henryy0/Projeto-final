<?php
// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Incluir arquivo de conexão com o banco de dados
    require_once('../includes/db.php');

    // Verificar se todos os campos necessários foram enviados
    if (isset($_POST['idEquipeEditar'], $_POST['nomeEquipeEditar'], $_POST['liderEquipeEditar'], $_POST['membrosEquipeEditar'])) {
        // Obter os dados do formulário
        $idEquipeEditar = $_POST['idEquipeEditar'];
        $nomeEquipeEditar = $_POST['nomeEquipeEditar'];
        $liderEquipeEditar = $_POST['liderEquipeEditar'];
        $membrosEquipeEditar = $_POST['membrosEquipeEditar'];

        // Consulta SQL para atualizar os detalhes da equipe
        $sql_update_equipe = "UPDATE Equipe SET equipe_nome = '$nomeEquipeEditar', equipe_lider_id = $liderEquipeEditar WHERE equipe_id = $idEquipeEditar";

        // Executar a consulta
        if ($conn->query($sql_update_equipe) === TRUE) {
            // Atualizar membros da equipe
            // Primeiro, excluir todos os membros da equipe
            $sql_delete_members = "DELETE FROM Equipe_Membro WHERE equipe_id = $idEquipeEditar";

            // Executar a consulta para excluir os membros existentes
            if ($conn->query($sql_delete_members) === TRUE) {
                // Em seguida, adicionar os novos membros à equipe
                foreach ($membrosEquipeEditar as $membro) {
                    $sql_add_member = "INSERT INTO Equipe_Membro (equipe_id, usuario_id) VALUES ($idEquipeEditar, $membro)";

                    // Executar a consulta para adicionar membros
                    $conn->query($sql_add_member);
                }

                // Equipe atualizada com sucesso
                header("Location: equipe.php");
            } else {
                // Se houver erro ao excluir membros da equipe
                echo "Erro ao excluir membros da equipe: " . $conn->error;
            }
        } else {
            // Se houver erro ao atualizar os detalhes da equipe
            echo "Erro ao atualizar equipe: " . $conn->error;
        }

        // Fechar conexão com o banco de dados
        $conn->close();
    } else {
        // Se algum dos campos necessários não foi enviado
        echo "Todos os campos são obrigatórios.";
    }
} else {
    // Se o formulário não foi enviado via método POST
    echo "O formulário não foi enviado corretamente.";
}
?>
