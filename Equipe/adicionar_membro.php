<?php
// Check if the form was submitted using the POST method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Include the file for connecting to the database
    require_once('../includes/db.php');

    // Check if all required fields are present in the POST data
    if (isset($_POST['nomeMembro'], $_POST['equipeMembro'])) {
        // Get the form data
        $nomeMembro = $_POST['nomeMembro'];
        $equipeMembro = $_POST['equipeMembro'];

        // Prepare the SQL statement to check if the member is already in the team
        $sql_check_member = "SELECT COUNT(*) AS total FROM Equipe_Membro WHERE equipe_id = ? AND usuario_id = (SELECT id_usuario FROM Usuario WHERE nome_usuario = ?)";

        // Use prepared statements to prevent SQL injection
        $stmt_check_member = $conn->prepare($sql_check_member);
        $stmt_check_member->bind_param("is", $equipeMembro, $nomeMembro);
        $stmt_check_member->execute();
        $result_check_member = $stmt_check_member->get_result();

        // Check if the query was successful
        if ($result_check_member) {
            $row = $result_check_member->fetch_assoc();
            if ($row['total'] > 0) {
                // The member is already in the team
                echo "O membro já está na equipe.";
            } else {
                // Prepare the SQL statement to add the member to the team
                $sql_add_member = "INSERT INTO Equipe_Membro (equipe_id, usuario_id) VALUES (?, (SELECT id_usuario FROM Usuario WHERE nome_usuario = ?))";

                // Use prepared statements to prevent SQL injection
                $stmt_add_member = $conn->prepare($sql_add_member);
                $stmt_add_member->bind_param("is", $equipeMembro, $nomeMembro);
                if ($stmt_add_member->execute()) {
                    // Member added successfully
                    // Redirecionar para equipe.php
                    header("Location: equipe.php");
                    exit(); // Certifique-se de sair após o redirecionamento
                } else {
                    // If there's an error while adding the member to the team
                    echo "Erro ao adicionar membro à equipe: " . $stmt_add_member->error;
                }
            }
        } else {
            // If there's an error in the query
            echo "Erro ao verificar o membro na equipe.";
        }

        // Close the prepared statements
        $stmt_check_member->close();
        $stmt_add_member->close();

    } else {
        // If any of the required fields were not sent
        echo "Todos os campos são obrigatórios.";
    }

    // Close the database connection
    $conn->close();
} else {
    // If the form wasn't submitted using the POST method
    echo "O formulário não foi enviado corretamente.";
}
?>
