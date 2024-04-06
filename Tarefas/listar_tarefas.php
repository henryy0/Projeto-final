<?php
require_once('../includes/db.php');
session_start();
$id_usuario = isset($_SESSION['id_usuario']) ? $_SESSION['id_usuario'] : null;
$pasta_imagens = '../img/usuarios/'; // Caminho para a pasta de imagens de usuários
$sql = "SELECT T.ID_tarefa, T.Nome_tarefa, T.Data_inicio_Tarefa, T.Data_Fim_Tarefa, T.Obs_tarefa, T.Status_tarefa, U.nome_usuario, U.id_usuario, U.foto_usuario, P.Nome_Projeto
        FROM Tarefa T
        LEFT JOIN Usuario U ON T.Responsavel_tarefa = U.id_usuario
        LEFT JOIN Projeto P ON T.Projeto_tarefa = P.ID_Projeto"; // Adicionando JOIN com a tabela de projetos
$result = $conn->query($sql);
$tarefas = array();
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        // Construindo o caminho para a imagem do usuário
        $caminho_imagem = $pasta_imagens . $row['id_usuario'] . '/' . $row['foto_usuario'];
        
        // Verifica se a imagem existe no caminho especificado
        if (!file_exists($caminho_imagem)) {
            // Se não existir, define o caminho para a imagem padrão
            $caminho_imagem = '../img/usuarios/default.jpg';
        }
        
        // Adiciona os dados da tarefa ao array
        $tarefas[] = array(
            'ID_Tarefa' => $row['ID_tarefa'],
            'Nome_Tarefa' => $row['Nome_tarefa'],
            'Data_Inicio_Tarefa' => $row['Data_inicio_Tarefa'],
            'Data_Fim_Tarefa' => $row['Data_Fim_Tarefa'],
            'Descricao_Tarefa' => $row['Obs_tarefa'],
            'Status_Tarefa' => $row['Status_tarefa'],
            'Nome_Responsavel' => $row['nome_usuario'],
            'Foto_Responsavel' => $caminho_imagem,
            'Nome_Projeto' => $row['Nome_Projeto'] // Incluindo o nome do projeto
        );
    }
} else {
    echo "0 resultados";
}
$conn->close();
return $tarefas;
?>
