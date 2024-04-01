<?php
// Inclui o arquivo de conexão com o banco de dados
include "../includes/db.php";

// Obtém os dados do formulário
$nome = $_POST['nome'];
$sobrenome = $_POST['sobrenome'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$login = $_POST['login'];
$senha = $_POST['senha'];
$confirmar_senha = $_POST['confirmar_senha'];
$foto = $_FILES['foto']['name']; // Nome do arquivo da foto

// Verifica se as senhas coincidem
if ($senha !== $confirmar_senha) {
    echo "As senhas não coincidem.";
    exit();
}

// Verifica se o login já existe
$verifica_login = "SELECT * FROM Usuario WHERE login_usuario = '$login'";
$resultado = $conn->query($verifica_login);
if ($resultado->num_rows > 0) {
    echo "Login já em uso. Por favor, escolha outro login.";
    exit();
}

// Hash da senha
$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

// Insere os dados no banco de dados
$sql = "INSERT INTO Usuario (nome_usuario, sobrenome_usuario, email_usuario, telefone_usuario, login_usuario, senha_usuario, foto_usuario)
        VALUES ('$nome', '$sobrenome', '$email', '$telefone', '$login', '$senha_hash', '$foto')";
if ($conn->query($sql) === TRUE) {
    // Obtém o ID do usuário recém-criado
    $id_usuario = $conn->insert_id;

    // Cria o diretório com base no ID do usuário na pasta img/usuarios
    $pasta_usuario = "../img/usuarios/$id_usuario/";
    if (!file_exists($pasta_usuario)) {
        mkdir($pasta_usuario, 0777, true); // Cria a pasta com permissões de escrita
    }

    // Move o arquivo da foto para o diretório do usuário
    $foto_destino = $pasta_usuario . basename($foto);
    move_uploaded_file($_FILES['foto']['tmp_name'], $foto_destino);

    // Redireciona o usuário para o index após o cadastro
    header("Location: ../index.php");
    exit();
} else {
    echo "Erro ao cadastrar usuário: " . $conn->error;
}

$conn->close();
?>
