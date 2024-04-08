<?php

session_start();

# Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
	
	# Inclui o arquivo de conexão com o banco de dados
	include '../../../includes/db.php';

	# Obtém o ID do usuário logado da SESSÃO
	$id = $_SESSION['id_usuario'];

	$sql = "UPDATE Usuario
	        SET ultimo_acesso = CURRENT_TIMESTAMP
	        WHERE id_usuario = ?";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id]);

} else {
	header("Location: ../../../index.php");
	exit;
}
?>
