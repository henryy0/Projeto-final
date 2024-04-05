<?php
// Incluir arquivo de conexão com o banco de dados
include "../includes/db.php";

// Consulta SQL para selecionar todos os projetos
$sql = "SELECT ID_Projeto, Nome_Projeto FROM Projeto";
$result = $conn->query($sql);

// Verificar se há registros retornados
if ($result->num_rows > 0) {
    // Início do menu suspenso
    echo '<option value="">Selecione o Projeto</option>';
    // Loop através dos resultados da consulta
    while ($row = $result->fetch_assoc()) {
        // Adicionar uma opção para cada projeto
        echo '<option value="' . $row["ID_Projeto"] . '">' . $row["Nome_Projeto"] . '</option>';
    }
} else {
    echo '<option value="" disabled>Nenhum projeto encontrado</option>';
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
