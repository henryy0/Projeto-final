<?php
require_once '../includes/db.php'; // Conexão com o banco de dados

// Consulta SQL para obter todas as tarefas com informações do responsável
$sql = "SELECT Tarefa.*, Usuario.nome_usuario, Usuario.foto_usuario 
        FROM Tarefa 
        LEFT JOIN Usuario ON Tarefa.Responsavel_tarefa = Usuario.id_usuario";

// Executar a consulta
$resultado = $conn->query($sql);

// Verificar se há resultados
if ($resultado->num_rows > 0) {
    // Inicializar um array para armazenar as tarefas
    $tarefas = array();

    // Loop através dos resultados
    while ($row = $resultado->fetch_assoc()) {
        // Construir um array com informações da tarefa
        $tarefa = array(
            'ID_Tarefa' => $row['ID_tarefa'],
            'Nome_Tarefa' => $row['Nome_tarefa'],
            'Data_Inicio_Tarefa' => $row['Data_inicio_Tarefa'],
            'Data_Fim_Tarefa' => $row['Data_Fim_Tarefa'],
            'Status_Tarefa' => $row['Status_tarefa'],
            'Descricao_Tarefa' => $row['Obs_tarefa'],
            'Responsavel_Nome' => $row['nome_usuario'],
            'Responsavel_Foto' => $row['foto_usuario']
        );

        // Adicionar a tarefa ao array de tarefas
        $tarefas[] = $tarefa;
    }
} else {
    // Se não houver tarefas, exibir uma mensagem de aviso
    echo "Nenhuma tarefa encontrada.";
}

// Fechar a conexão com o banco de dados
$conn->close();

// Retornar o array de tarefas
return $tarefas;
?>
