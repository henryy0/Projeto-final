<?php
// Inclua o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Consulta SQL para obter as equipes e os projetos atribuídos a cada equipe
$sql = "SELECT e.*, p.Nome_Projeto 
        FROM Equipe e
        LEFT JOIN Equipe_Projeto ep ON e.equipe_id = ep.equipe_id
        LEFT JOIN Projeto p ON ep.projeto_id = p.ID_Projeto";

$result = $conn->query($sql);

$equipes = array();

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $equipe_id = $row["equipe_id"];
        $equipe_nome = $row["equipe_nome"];
        $equipe_descricao = $row["equipe_descricao"];
        $equipe_lider_id = $row["equipe_lider_id"];
        $lider_email = $row["lider_email"];
        $projeto_nome = $row["Nome_Projeto"];

        // Consulta para obter o nome do líder da equipe
        $sql_lider = "SELECT nome_usuario FROM Usuario WHERE id_usuario = $equipe_lider_id";
        $result_lider = $conn->query($sql_lider);
        $lider_nome = "";
        if ($result_lider && $result_lider->num_rows > 0) {
            $row_lider = $result_lider->fetch_assoc();
            $lider_nome = $row_lider["nome_usuario"];
        }

        // Consulta para obter os membros da equipe
        $sql_membros = "SELECT u.id_usuario, u.nome_usuario 
                        FROM Usuario u 
                        JOIN Equipe_Membro em ON u.id_usuario = em.usuario_id 
                        WHERE em.equipe_id = $equipe_id";
        $result_membros = $conn->query($sql_membros);
        $membros = array();
        if ($result_membros && $result_membros->num_rows > 0) {
            while ($row_membro = $result_membros->fetch_assoc()) {
                $membros[] = $row_membro;
            }
        }

        // Verifica se a equipe já existe no array
        if (!isset($equipes[$equipe_id])) {
            // Construir array com os dados da equipe
            $equipes[$equipe_id] = array(
                "id" => $equipe_id,
                "nome" => $equipe_nome,
                "descricao" => $equipe_descricao,
                "lider_id" => $equipe_lider_id,
                "lider_nome" => $lider_nome,
                "lider_email" => $lider_email,
                "membros" => $membros,
                "projetos" => array() // Inicializa o array de projetos
            );
        }

        // Adiciona o projeto ao array de projetos da equipe
        if (!empty($projeto_nome)) {
            $equipes[$equipe_id]["projetos"][] = $projeto_nome;
        }
    }
}

// Fechar conexão com o banco de dados
$conn->close();

// Retornar equipes
return array_values($equipes); // Retorna os valores do array de equipes para reindexá-lo
?>
