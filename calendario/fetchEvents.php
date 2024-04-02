<?php
// Incluir arquivo de configuração do banco de dados
require_once '../includes/db.php';

// Consulta SQL para selecionar todos os eventos
$sql = "SELECT * FROM calendario";

// Executar consulta
$resultado = $mysqli->query($sql);

// Array para armazenar os eventos
$eventos = array();

// Verificar se há resultados
if ($resultado) {
    // Loop através dos resultados e adicionar eventos ao array
    while ($row = $resultado->fetch_assoc()) {
        $eventos[] = array(
            'id' => $row['id'],
            'title' => $row['titulo'],
            'description' => $row['descricao'],
            'url' => $row['url'],
            'start' => $row['inicio'],
            'end' => $row['fim']
        );
    }
}

// Fechar conexão com o banco de dados
$mysqli->close();

// Retornar eventos no formato JSON
echo json_encode($eventos);
?>
