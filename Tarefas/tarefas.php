<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tarefas do Projeto</title>
    <link rel="stylesheet" href="../css/tarefas.css"> <!-- Link para o CSS específico da página de tarefas -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Tarefas do Projeto</h1>
        <!-- Botão para adicionar tarefa -->
        <button onclick="abrirModalAdicionarTarefa()">Adicionar Tarefa</button>

        <!-- Botões de filtro -->
        <div class="filtro-container">
            <button onclick="filtrarTarefas('todos')">Todos</button>
            <button onclick="filtrarTarefas('em andamento')">Em Andamento</button>
            <button onclick="filtrarTarefas('concluido')">Concluído</button>
            <button onclick="filtrarTarefas('pausado')">Pausado</button>
        </div>

        <div class="tarefa-container">
            <?php
            // Incluir o arquivo externo com a lógica PHP para listar as tarefas do projeto
            $tarefas = require_once('listar_tarefas.php');

            foreach ($tarefas as $tarefa) :
            ?>
                <div class="tarefa-card" data-status="<?= strtolower($tarefa['Status_Tarefa']) ?>">
                    <h2><?= $tarefa['Nome_Tarefa'] ?></h2>
                    <p><strong>Projeto:</strong> <?= $tarefa['Nome_Projeto'] ?></p> <!-- Novo trecho para exibir o nome do projeto -->
                    <p><strong>Data de Início:</strong> <?= $tarefa['Data_Inicio_Tarefa'] ?></p>
                    <p><strong>Data de Término:</strong> <?= $tarefa['Data_Fim_Tarefa'] ?></p>
                    <p><strong>Status:</strong> <?= $tarefa['Status_Tarefa'] ?></p>
                    <p><strong>Descrição:</strong> <?= $tarefa['Descricao_Tarefa'] ?></p>

                    <!-- Responsável pela Tarefa -->
                    <div class="responsavel-tarefa">
                        <?php if (!empty($tarefa['Foto_Responsavel'])) : ?>
                            <img src="<?= $tarefa['Foto_Responsavel'] ?>" alt="Foto do Responsável">
                        <?php else : ?>
                            <p>Não há foto disponível</p>
                        <?php endif; ?>
                        <p><?= $tarefa['Nome_Responsavel'] ?></p>
                    </div>

                    <!-- Botões de Ação -->
                    <div class="botoes-acao">
                        <button onclick="abrirModalConcluirTarefa(<?= $tarefa['ID_Tarefa'] ?>)">Concluir</button>
                        <button onclick="abrirModalEditarTarefa(<?= $tarefa['ID_Tarefa'] ?>)">Editar</button>
                        <button onclick="abrirModalPausarTarefa(<?= $tarefa['ID_Tarefa'] ?>)">Pausar</button>
                        <button onclick="abrirModalExcluirTarefa(<?= $tarefa['ID_Tarefa'] ?>)">Excluir</button>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>



    <!-- Modal para Adicionar Tarefa -->
    <div id="modalAdicionarTarefa" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionarTarefa()">&times;</span>
            <h2>Adicionar Tarefa</h2>
            <!-- Formulário de adição de tarefa -->
            <form id="formAdicionarTarefa" action="adicionar_tarefa.php" method="POST">
                <label for="nomeTarefa">Nome da Tarefa:</label>
                <input type="text" id="nomeTarefa" name="nomeTarefa" required>

                <label for="dataInicio">Data de Início:</label>
                <input type="date" id="dataInicio" name="dataInicio" required>

                <label for="dataFim">Data de Término:</label>
                <input type="date" id="dataFim" name="dataFim">

                <label for="descricaoTarefa">Descrição da Tarefa:</label>
                <textarea id="descricaoTarefa" name="descricaoTarefa" required></textarea>

                <label for="projetoTarefa">Projeto:</label>
                <select id="projetoTarefa" name="projetoTarefa" required>
                    <!-- Opções preenchidas dinamicamente pelo PHP -->
                    <?php include '../projetos/opcoes_projetos.php'; ?>
                </select>

                <label for="responsavelTarefaAdicionar">Responsável pela Tarefa:</label>
                <select id="responsavelTarefaAdicionar" name="responsavelTarefa" required>
                    <!-- Opções preenchidas dinamicamente pelo PHP -->
                    <?php include '../usuarios/opcoes_usuarios.php'; ?>
                </select>


                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Modal para Editar Tarefa -->
    <div id="modalEditarTarefa" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditarTarefa()">&times;</span>
            <h2>Editar Tarefa</h2>
            <!-- Formulário de edição de tarefa -->
            <form id="formEditarTarefa" action="editar_tarefa.php" method="POST">
                <input type="hidden" id="idTarefaEditar" name="idTarefaEditar">
                <label for="nomeTarefaEditar">Nome da Tarefa:</label>
                <input type="text" id="nomeTarefaEditar" name="nomeTarefaEditar" required>

                <label for="dataInicioEditar">Data de Início:</label>
                <input type="date" id="dataInicioEditar" name="dataInicioEditar" required>

                <label for="dataFimEditar">Data de Término:</label>
                <input type="date" id="dataFimEditar" name="dataFimEditar">

                <label for="descricaoTarefaEditar">Descrição da Tarefa:</label>
                <textarea id="descricaoTarefaEditar" name="descricaoTarefaEditar" required></textarea>

                <label for="projetoTarefa">Projeto:</label>
                <select id="projetoTarefa" name="projetoTarefa" required>
                    <!-- Opções preenchidas dinamicamente pelo PHP -->
                    <?php include '../projetos/opcoes_projetos.php'; ?>
                </select>

                <label for="responsavelTarefaAdicionar">Responsável pela Tarefa:</label>
                <select id="responsavelTarefaAdicionar" name="responsavelTarefa" required>
                    <!-- Opções preenchidas dinamicamente pelo PHP -->
                    <?php include '../usuarios/opcoes_usuarios.php'; ?>
                </select>

                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal para Concluir Tarefa -->
    <div id="modalConcluirTarefa" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="fecharModalConcluirTarefa()">&times;</span>
            <h2>Concluir Tarefa</h2>
            <form id="formConcluirTarefa" action="concluir_tarefa.php" method="POST">
                <p>Tem certeza de que deseja marcar esta tarefa como concluída?</p>
                <!-- Campo oculto para enviar o ID da tarefa a ser concluída -->
                <input type="hidden" id="idTarefaConcluir" name="idTarefaConcluir">
                <button type="submit">Sim, Concluir</button>
            </form>
        </div>
    </div>

    <!-- Modal para Pausar Tarefa -->
    <div id="modalPausarTarefa" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="fecharModalPausarTarefa()">&times;</span>
            <h2>Pausar Tarefa</h2>
            <!-- Formulário de confirmação de pausa da tarefa -->
            <form id="formPausarTarefa" action="pausar_tarefa.php" method="POST">
                <p>Tem certeza de que deseja pausar esta tarefa?</p>
                <!-- Campo oculto para enviar o ID da tarefa a ser pausada -->
                <input type="hidden" id="idTarefaPausar" name="idTarefaPausar">
                <button type="submit">Sim, Pausar</button>
            </form>
        </div>
    </div>


    <!-- Modal para Excluir Tarefa -->
    <div id="modalExcluirTarefa" class="modal" style="display: none;">
        <div class="modal-content">
            <span class="close" onclick="fecharModalExcluirTarefa()">&times;</span>
            <h2>Excluir Tarefa</h2>
            <!-- Formulário de confirmação de exclusão da tarefa -->
            <form id="formExcluirTarefa" action="excluir_tarefa.php" method="POST">
                <p>Tem certeza de que deseja excluir esta tarefa?</p>
                <!-- Campo oculto para enviar o ID da tarefa a ser excluída -->
                <input type="hidden" id="idTarefaExcluir" name="idTarefaExcluir">
                <button type="submit">Sim, Excluir</button>
            </form>
        </div>
    </div>

    <script src="../js/tarefas.js"></script> <!-- Script externo para interatividade -->
</body>

</html>
