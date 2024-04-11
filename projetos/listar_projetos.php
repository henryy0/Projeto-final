<?php
// Incluir o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Função para calcular a porcentagem de conclusão do projeto
function calcularPorcentagemConclusao($porcentagemConclusao) {
    return $porcentagemConclusao;
}

// Consulta SQL para selecionar todos os projetos com informações da equipe e membros
$sql = "SELECT p.*, e.equipe_id AS equipe_id, e.equipe_nome AS equipe_nome,
               e.equipe_lider_id AS equipe_lider_id, u.nome_usuario AS nome_lider,
               GROUP_CONCAT(DISTINCT CASE WHEN em.usuario_id != e.equipe_lider_id THEN em.usuario_id END SEPARATOR ',') AS membros_id,
               GROUP_CONCAT(DISTINCT CASE WHEN em.usuario_id != e.equipe_lider_id THEN u2.nome_usuario END SEPARATOR ',') AS membros_nome
        FROM Projeto p
        LEFT JOIN Equipe_Projeto ep ON p.ID_Projeto = ep.projeto_id
        LEFT JOIN Equipe e ON ep.equipe_id = e.equipe_id
        LEFT JOIN Usuario u ON e.equipe_lider_id = u.id_usuario
        LEFT JOIN Equipe_Membro em ON e.equipe_id = em.equipe_id
        LEFT JOIN Usuario u2 ON em.usuario_id = u2.id_usuario
        GROUP BY p.ID_Projeto";

$resultado = $conn->query($sql);

// Array para armazenar os projetos
$projetos = array();

// Verificar se há resultados
if ($resultado && $resultado->num_rows > 0) {
    // Loop através dos resultados e adicionar projetos ao array
    while ($row = $resultado->fetch_assoc()) {
        // Consulta SQL para selecionar as tarefas do projeto
        $sql_tarefas = "SELECT * FROM Tarefa WHERE Projeto_tarefa = {$row['ID_Projeto']}";
        $resultado_tarefas = $conn->query($sql_tarefas);

        // Array para armazenar as tarefas do projeto
        $tarefas = array();
        if ($resultado_tarefas && $resultado_tarefas->num_rows > 0) {
            while ($tarefa = $resultado_tarefas->fetch_assoc()) {
                $tarefas[] = $tarefa;
            }
        }

        // Atribuir tarefas ao projeto
        $row['tarefas'] = $tarefas;

        // Calcular a porcentagem de conclusão do projeto
        $porcentagem_conclusao = calcularPorcentagemConclusao($row['Porcentagem_Conclusao']);

        // Verificar se a porcentagem de conclusão é 100% e atualizar o status do projeto
        if ($porcentagem_conclusao == 100 && $row['Status_Projeto'] != 'Concluído') {
            // Aqui você pode chamar a função para atualizar o status do projeto
            // atualizarStatusProjeto($row['ID_Projeto'], 'Concluído');
            $row['Status_Projeto'] = 'Concluído'; // Atualiza localmente para evitar mais consultas
        }

        // Converter a string de membros em um array
        $membros_id_array = explode(',', $row['membros_id']);
        $membros_nome_array = explode(',', $row['membros_nome']);

        // Combinar IDs e nomes de membros em um array associativo
        $membros = array();
        foreach ($membros_id_array as $index => $membro_id) {
            $nome_membro = isset($membros_nome_array[$index]) ? $membros_nome_array[$index] : 'Nome não disponível';
            $membros[] = array(
                'id' => $membro_id,
                'nome' => $nome_membro
            );
        }
        
        // Adicionar membros ao projeto
        $row['membros'] = $membros;

        // Adicionar projeto ao array de projetos
        $projetos[] = $row;
    }
}

// Fechar conexão com o banco de dados
$conn->close();

// Retornar projetos
return $projetos;
?>
