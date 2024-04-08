<?php
// Incluir o arquivo de conexão com o banco de dados
require_once '../includes/db.php';

// Função para calcular a porcentagem de conclusão do projeto
function calcularPorcentagemConclusao($porcentagemConclusao) {
    return $porcentagemConclusao;
}

// Função para atualizar o status do projeto no banco de dados
function atualizarStatusProjeto($id_projeto, $novo_status) {
    global $conn;
    $id_projeto = $conn->real_escape_string($id_projeto);
    $novo_status = $conn->real_escape_string($novo_status);

    $query = "UPDATE Projeto SET Status_Projeto = '$novo_status' WHERE ID_Projeto = $id_projeto";
    $conn->query($query);
}

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
        $sql_equipe = "SELECT * FROM Equipe WHERE projeto_atribuido_id = {$row['ID_Projeto']}";
        $resultado_equipe = $conn->query($sql_equipe);

        // Array para armazenar as informações da equipe
        $equipe = array();
        if ($resultado_equipe && $resultado_equipe->num_rows > 0) {
            $equipe_info = $resultado_equipe->fetch_assoc();

            // Verificar se há líder da equipe
            if (isset($equipe_info['equipe_lider_id']) && !empty($equipe_info['equipe_lider_id'])) {
                // Consulta SQL para selecionar o líder da equipe
                $sql_lider_equipe = "SELECT * FROM Usuario WHERE id_usuario = {$equipe_info['equipe_lider_id']}";
                $resultado_lider_equipe = $conn->query($sql_lider_equipe);

                if ($resultado_lider_equipe && $resultado_lider_equipe->num_rows > 0) {
                    $lider_equipe = $resultado_lider_equipe->fetch_assoc();
                    $equipe['equipe_lider'] = $lider_equipe;
                } else {
                    echo "Erro ao recuperar líder da equipe.";
                }
            } else {
                echo "Nenhum líder de equipe atribuído.";
            }

            // Restante do código para recuperar membros da equipe...

            // Atribuir informações da equipe ao array de equipe
            $equipe['membros'] = $membros_equipe;
        } else {
            echo "Nenhuma equipe atribuída a este projeto.";
        }

        // Atribuir tarefas e equipe ao projeto
        $row['tarefas'] = $tarefas;
        $row['equipe'] = $equipe;

        // Calcular a porcentagem de conclusão do projeto
        $porcentagem_conclusao = calcularPorcentagemConclusao($row['Porcentagem_Conclusao']);

        // Verificar se a porcentagem de conclusão é 100% e atualizar o status do projeto
        if ($porcentagem_conclusao == 100 && $row['Status_Projeto'] != 'Concluído') {
            atualizarStatusProjeto($row['ID_Projeto'], 'Concluído');
            $row['Status_Projeto'] = 'Concluído'; // Atualiza localmente para evitar mais consultas
        }

        // Adicionar projeto ao array de projetos
        $projetos[] = $row;
    }
}

// Fechar conexão com o banco de dados
$conn->close();

// Retornar projetos
return $projetos;
?>
