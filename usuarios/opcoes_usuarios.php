<?php
// Incluir arquivo de conexão com o banco de dados
include "../includes/db.php";

// Consulta SQL para selecionar todos os usuários
$sql = "SELECT id_usuario, nome_usuario FROM Usuario";
$result = $conn->query($sql);

// Verificar se há registros retornados
if ($result->num_rows > 0) {
    // Início do menu suspenso
    echo '<option value="">Selecione o Responsável</option>';
    // Loop através dos resultados da consulta
    while ($row = $result->fetch_assoc()) {
        // Adicionar uma opção para cada usuário
        echo '<option value="' . $row["id_usuario"] . '">' . $row["nome_usuario"] . '</option>';
    }
} else {
    echo "0 resultados";
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
