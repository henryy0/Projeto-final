<?php
// Função para calcular a porcentagem de conclusão do projeto
function calcularPorcentagemConclusao($numTarefasConcluidas, $numTotalTarefas) {
    if ($numTotalTarefas > 0) {
        return round(($numTarefasConcluidas / $numTotalTarefas) * 100, 2);
    } else {
        return 0;
    }
}

// Inclua o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Consulta SQL para selecionar todos os projetos
$sql = "SELECT * FROM Projeto";
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

        // Consulta SQL para selecionar as informações da equipe do projeto
        $sql_equipe = "SELECT * FROM Equipe WHERE Projeto_atribuido_ID = {$row['ID_Projeto']}";
        $resultado_equipe = $conn->query($sql_equipe);

        // Array para armazenar as informações da equipe
        $equipe = array();
        if ($resultado_equipe && $resultado_equipe->num_rows > 0) {
            $equipe_info = $resultado_equipe->fetch_assoc();

            // Verifica se a chave 'equipe_lider_id' existe em $equipe_info
            if(isset($equipe_info['equipe_lider_id'])){
                $equipe_lider_id = $equipe_info['equipe_lider_id'];
            }else{
                $equipe_lider_id = null;
            }
            
            // Consulta SQL para selecionar os membros da equipe
            $sql_membros_equipe = "SELECT * FROM Usuario WHERE id_usuario IN (SELECT equipe_membro_id FROM Equipe_Membro WHERE equipe_id = {$equipe_info['equipe_id']})";
            $resultado_membros_equipe = $conn->query($sql_membros_equipe);

            $membros_equipe = array();
            if ($resultado_membros_equipe && $resultado_membros_equipe->num_rows > 0) {
                while ($membro = $resultado_membros_equipe->fetch_assoc()) {
                    $membros_equipe[] = $membro;
                }
            }

            // Atribuir informações da equipe ao array de equipe
            $equipe['equipe_lider_id'] = $equipe_lider_id;
            $equipe['membros'] = $membros_equipe;
        }

        // Atribuir tarefas e equipe ao projeto
        $row['tarefas'] = $tarefas;
        $row['equipe'] = $equipe;

        // Adicionar projeto ao array de projetos
        $projetos[] = $row;
    }
}

// Fechar conexão com o banco de dados
$conn->close();

// Retornar projetos
return $projetos;
?>
