<?php
// Inclua o arquivo de conexão com o banco de dados
include_once 'includes/db.php';

// Verifique se o formulário foi submetido
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verifique se o e-mail foi enviado
    if (isset($_POST["email"])) {
        $email = $_POST["email"];

        // Verifique se o e-mail existe no banco de dados
        $sql = "SELECT * FROM Usuario WHERE email_usuario = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Gerar token de redefinição de senha
            $token = bin2hex(random_bytes(32));

            // Atualizar o token no banco de dados
            $sql = "UPDATE Usuario SET token_recuperacao = :token WHERE id_usuario = :id_usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':token', $token);
            $stmt->bindParam(':id_usuario', $user['id_usuario']);
            $stmt->execute();

            // Enviar e-mail com link para redefinição de senha
            $assunto = "Redefinição de senha";
            $mensagem = "Olá! Para redefinir sua senha, clique no seguinte link: http://seusite.com/redefinir_senha.php?token=$token";
            $headers = "De: seuemail@seudominio.com" . "\r\n" .
                       "Reply-To: seuemail@seudominio.com" . "\r\n" .
                       "X-Mailer: PHP/" . phpversion();

            // Envie o e-mail
            if (mail($email, $assunto, $mensagem, $headers)) {
                echo "Um e-mail de redefinição de senha foi enviado para o seu endereço de e-mail.";
            } else {
                echo "Houve um erro ao enviar o e-mail. Por favor, tente novamente mais tarde.";
            }
        } else {
            echo "E-mail não cadastrado. Por favor, verifique o e-mail fornecido.";
        }
    }
}
?>
