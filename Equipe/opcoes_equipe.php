<?php
// Incluir arquivo de conexão com o banco de dados
include "../includes/db.php";

// Consulta SQL para selecionar todas as equipes
$sql = "SELECT equipe_id, equipe_nome FROM Equipe";
$result = $conn->query($sql);

// Verificar se há registros retornados
if ($result->num_rows > 0) {
    // Início do menu suspenso
    echo '<option value="" disabled>Selecione a Equipe</option>';
    // Loop através dos resultados da consulta
    while ($row = $result->fetch_assoc()) {
        // Adicionar uma opção para cada equipe
        echo '<option value="' . $row["equipe_id"] . '">' . $row["equipe_nome"] . '</option>';
    }
} else {
    echo '<option value="">Nenhuma equipe encontrada</option>';
}

// Fechar a conexão com o banco de dados
$conn->close();
?>
