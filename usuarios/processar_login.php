<?php
// Inclui o arquivo de conexão com o banco de dados
include "../includes/db.php";

// Inicia a sessão
session_start();

// Verifica se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recebe os dados do formulário
    $login = $_POST["login"];
    $senha = $_POST["senha"];

    // Consulta o banco de dados para verificar se o usuário existe
    $sql = "SELECT * FROM Usuario WHERE login_usuario='$login'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        // Usuario encontrado
        $row = $result->fetch_assoc();
        // Verifica se a senha fornecida corresponde à senha armazenada no banco de dados
        if (password_verify($senha, $row["senha_usuario"])) {
            // Senha correta, realiza o login
            $_SESSION["login"] = $login;
            header("Location: ../sistema.php"); // Redireciona para a página principal após o login
            exit();
        } else {
            // Senha incorreta
            header("Location: ../index.php?error=login_failed");
            exit();
        }
    } else {
        // Usuário não encontrado
        header("Location: ../index.php?error=login_failed");
        exit();
    }
}

// Fecha a conexão com o banco de dados
$conn->close();
?>
