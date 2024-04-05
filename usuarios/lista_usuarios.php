<?php
// Inclua o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Verifique se a conexão foi estabelecida com sucesso
if ($conexao) {
    // Consulta SQL para selecionar os usuários existentes
    $sql = "SELECT id_usuario, nome_usuario FROM Usuario";

    // Executa a consulta
    $result = mysqli_query($conexao, $sql);

    // Verifica se existem usuários
    if ($result && mysqli_num_rows($result) > 0) {
        // Loop através dos resultados para preencher a combobox
        while ($row = mysqli_fetch_assoc($result)) {
            echo '<option value="' . $row['id_usuario'] . '">' . $row['nome_usuario'] . '</option>';
        }
    } else {
        echo '<option value="" disabled>Nenhum usuário encontrado</option>';
    }

    // Fecha o resultado da consulta
    mysqli_free_result($result);
} else {
    // Exiba uma mensagem de erro caso a conexão não seja estabelecida
    echo '<option value="" disabled>Erro ao conectar ao banco de dados</option>';
}

// Fecha a conexão com o banco de dados
mysqli_close($conexao);
?>
