<?php
session_start();

# Verifica se o usuário está logado
if (isset($_SESSION['id_usuario'])) {
    # Verifica se a chave de busca foi enviada
    if(isset($_POST['key'])){
        # Inclui o arquivo de conexão com o banco de dados
        include '../../../includes/db.php';

        # Criando um algoritmo de busca simples :)
        $key = "%{$_POST['key']}%";
        
        $sql = "SELECT * FROM Usuario
                WHERE (login_usuario LIKE ? OR nome_usuario LIKE ?)
                AND id_usuario != ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssi", $key, $key, $_SESSION['id_usuario']);
        $stmt->execute();
        $result = $stmt->get_result();

        if($result->num_rows > 0){ 
            while ($usuario = $result->fetch_assoc()) {
                $outro_usuario_id = $usuario['id_usuario']; // Obtém o ID do outro usuário
        ?>
                <li class="list-group-item">
                    <a href="chat.php?user=<?=htmlspecialchars($usuario['id_usuario'])?>&id=<?=$outro_usuario_id?>"
                       class="d-flex justify-content-between align-items-center p-2">
                        <div class="d-flex align-items-center">
                            <?php if (!empty($usuario['foto_usuario'])) { ?>
                                <img src="uploads/<?=htmlspecialchars($usuario['foto_usuario'])?>"
                                     class="w-10 rounded-circle">
                            <?php } else { ?>
                                <div class="w-10 rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center">
                                    <span><?=substr(htmlspecialchars($usuario['nome_usuario']), 0, 1)?></span>
                                </div>
                            <?php } ?>
                            <h3 class="fs-xs m-2">
                                <?=htmlspecialchars($usuario['nome_usuario'])?> <?=htmlspecialchars($usuario['sobrenome_usuario'])?>
                            </h3>                
                        </div>
                    </a>
                </li>
        <?php 
            } 
        } else { ?>
            <div class="alert alert-info text-center">
                <i class="fa fa-user-times d-block fs-big"></i>
                O usuário "<?=htmlspecialchars($_POST['key'])?>" não foi encontrado.
            </div>
    <?php 
        }
    }

} else {
    header("Location: ../../../index.php");
    exit;
}
?>
