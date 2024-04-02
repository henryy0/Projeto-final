<?php 
// Inclua o arquivo de configuração do banco de dados
include_once '../includes/db.php'; 

/* 
 * Função de carregamento com base na solicitação Ajax 
 */ 
if(isset($_POST['func']) && !empty($_POST['func'])){ 
    switch($_POST['func']){ 
        case 'getCalender': 
            getCalender($_POST['year'],$_POST['month']); 
            break; 
        case 'getEvents': 
            getEvents($_POST['date']); 
            break; 
        default: 
            break; 
    } 
} 

/* 
 * Gere o calendário de eventos em formato HTML 
 */ 
function getCalender($year = '', $month = ''){ 
    // Se os parâmetros de ano e mês não forem fornecidos, use o ano e mês atuais
    $dateYear = ($year != '') ? $year : date("Y"); 
    $dateMonth = ($month != '') ? $month : date("m"); 
    // Restante do código permanece o mesmo
} 

/* 
 * Gere a lista de eventos em HTML 
 */ 
function getEvents($date = ''){ 
    // Se a data não for fornecida, use a data atual
    $date = $date ? $date : date("Y-m-d"); 
    
    // Realize a consulta SQL para obter os eventos nesta data
    global $mysqli;
    $result = $mysqli->query("SELECT titulo FROM calendario WHERE inicio = '".$date."'");
    $eventListHTML = ''; // Inicialize a string HTML
    
    if($result->num_rows > 0){ 
        // Se houver eventos, monte a lista HTML
        $eventListHTML .= '<h2 class="sidebar__heading">'.date("l", strtotime($date)).'<br>'.date("F d", strtotime($date)).'</h2>'; 
        $eventListHTML .= '<ul class="sidebar__list">'; 
        $eventListHTML .= '<li class="sidebar__list-item sidebar__list-item--complete">Eventos</li>'; 
        while($row = $result->fetch_assoc()){ 
            $eventListHTML .= '<li class="sidebar__list-item">'.$row['titulo'].'</li>'; 
        } 
        $eventListHTML .= '</ul>'; 
    }
    
    echo $eventListHTML; 
} 

/* 
 * Adicionar evento 
 */ 
if(isset($_POST['request_type']) && $_POST['request_type'] == 'addEvent'){
    // Extrair os dados do evento
    $titulo = $_POST['event_data'][0];
    $descricao = $_POST['event_data'][1];
    $url = $_POST['event_data'][2];
    $inicio = $_POST['start'];
    $fim = $_POST['end'];

    // Preparar e executar a consulta SQL para adicionar o evento
    $stmt = $mysqli->prepare("INSERT INTO calendario (titulo, descricao, url, inicio, fim) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $titulo, $descricao, $url, $inicio, $fim);
    $result = $stmt->execute();

    // Verificar se a inserção foi bem-sucedida
    if ($result) {
        echo json_encode(array("status" => 1));
    } else {
        echo json_encode(array("error" => "Falha ao adicionar o evento."));
    }
}

/* 
 * Excluir evento 
 */ 
if(isset($_POST['request_type']) && $_POST['request_type'] == 'deleteEvent'){
    // Extrair o ID do evento
    $id = $_POST['event_id'];

    // Preparar e executar a consulta SQL para excluir o evento
    $stmt = $mysqli->prepare("DELETE FROM calendario WHERE id=?");
    $stmt->bind_param("i", $id);
    $result = $stmt->execute();

    // Verificar se a exclusão foi bem-sucedida
    if ($result) {
        echo json_encode(array("status" => 1));
    } else {
        echo json_encode(array("error" => "Falha ao excluir o evento."));
    }
}
?>
