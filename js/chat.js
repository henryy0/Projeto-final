$(document).ready(function(){
    // Função para buscar usuários
    $('#searchUser').keyup(function(){
        var query = $(this).val();
        if(query != ''){
            $.ajax({
                url: 'ajax/search.php',
                method: 'POST',
                data: {key: query},
                success: function(data){
                    $('#searchResult').html(data);
                }
            });
        }
    });

    // Função para carregar informações do destinatário e mensagens do chat
    function loadRecipientInfoAndMessages(userId, userName){
        // Atualizar o cabeçalho do chat com as informações do destinatário, incluindo o último acesso
        $.ajax({
            url: 'ajax/update_last_seen.php', // Endpoint para obter o último acesso do destinatário
            method: 'POST',
            data: {recipient_id: userId},
            success: function(data){
                var lastSeen = data; // Último acesso retornado do servidor
                var recipientInfoHtml = '<img src="recipient_picture.jpg" alt="Recipient Picture"><h3>' + userName + '</h3><p>Último Acesso: ' + lastSeen + '</p>';
                $('#recipientInfo').html(recipientInfoHtml);
                // Atualiza o campo oculto com o ID do destinatário
                $('#recipientId').val(userId);
                // Carregar mensagens do chat
                loadChatMessages(userId);
            }
        });
    }

    // Função para carregar mensagens do chat
    function loadChatMessages(userId){
        if (userId !== '') {
            $.ajax({
                url: 'ajax/getMessage.php',
                method: 'POST',
                data: {para_id: userId},
                success: function(data){
                    $('#chatMessages').html(data);
                }
            });
        }
    }

    // Carregar mensagens ao carregar a página
    var recipientId = ''; // Coloque aqui o ID do destinatário
    loadChatMessages(recipientId);

    // Função para enviar mensagem
    $('#sendBtn').click(function(){
        console.log("Botão de enviar clicado"); // Verifica se o evento de clique está sendo acionado
        var message = $('#messageInput').val();
        var recipientId = $('#recipientId').val(); // Obtém o ID do destinatário do campo oculto
        if(message != '' && recipientId != ''){
            $.ajax({
                url: 'ajax/insert.php',
                method: 'POST',
                data: {texto_mensagem: message, para_id: recipientId},
                success: function(data){
                    console.log("Resposta do servidor:", data); // Exibe a resposta do servidor no console
                    $('#messageInput').val('');
                    loadChatMessages(recipientId);
                }
            });
        }
    });

    // Lidar com o clique em um usuário na lista de usuários
    $(document).on('click', '.user-list-item', function(){
        var userId = $(this).data('userid');
        var userName = $(this).data('username');
        loadRecipientInfoAndMessages(userId, userName);
    });
});
