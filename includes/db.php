<?php
// Configurações de conexão com o banco de dados
$host = "localhost"; // Host do banco de dados
$user = "root"; // Usuário do banco de dados
$password = ""; // Senha do banco de dados
$database = "SistemaDeGerenciamento"; // Nome do banco de dados

// Conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $database);

// Verifica se a conexão foi estabelecida com sucesso
if ($conn->connect_error) {
    die("Erro ao conectar ao banco de dados: " . $conn->connect_error);
}

// Configuração de charset para utf8
$conn->set_charset("utf8");
?>
