<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projetos</title>
    <link rel="stylesheet" href="../css/projetos.css"> <!-- Link para o CSS específico da página de projetos -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <h1>Projetos</h1>

        <!-- Botão para adicionar projeto -->
        <button onclick="abrirModalAdicionar()">Adicionar Projeto</button>

        <!-- Filtro de projetos -->
        <div class="filtro-container">
            <button onclick="filtrarProjetos('todos')">Todos</button>
            <button onclick="filtrarProjetos('em_andamento')">Em Andamento</button>
            <button onclick="filtrarProjetos('concluido')">Concluído</button>
            <button onclick="filtrarProjetos('pausado')">Pausado</button>
        </div>

        <!-- Container para os projetos -->
        <div class="projeto-container">
            <?php
            // Incluir o arquivo externo com a lógica PHP
            $projetos = require_once('listar_projetos.php');

            foreach ($projetos as $projeto) :
                // Calcular a porcentagem de conclusão do projeto
                $porcentagem_conclusao = calcularPorcentagemConclusao($projeto['Num_Tarefas_Concluidas'], $projeto['Num_Total_Tarefas']);
            ?>
                <div class="projeto-card" data-status="<?= strtolower($projeto['Status_Projeto']) ?>">
                    <h2><?= $projeto['Nome_Projeto'] ?></h2>
                    <p><strong>Tipo:</strong> <?= $projeto['Tipo_Projeto'] ?></p>
                    <p><strong>Data de Início:</strong> <?= $projeto['Data_inicio_Projeto'] ?></p>
                    <p><strong>Data de Término:</strong> <?= $projeto['Data_Fim_Projeto'] ?></p>
                    <p><strong>Status:</strong> <?= $projeto['Status_Projeto'] ?></p>
                    <p><strong>Resumo:</strong> <?= $projeto['Resumo_Projeto'] ?></p>
                    <p><strong>Riscos:</strong> <?= $projeto['Riscos_Projeto'] ?></p>
                    <p><strong>Orçamento:</strong> <?= $projeto['Orcamento_Projeto'] ?></p>
                    <p><strong>Recursos:</strong> <?= $projeto['Recursos_Projeto'] ?></p>
                    <p><strong>Porcentagem de Conclusão:</strong> <?= $porcentagem_conclusao ?>%</p>

                    <!-- Botões de Ação -->
                    <div class="botoes-acao">
                        <button onclick="abrirModalEditar(<?= $projeto['ID_Projeto'] ?>)">Editar</button>
                        <button onclick="abrirModalExcluir(<?= $projeto['ID_Projeto'] ?>)">Excluir</button>
                        <button onclick="abrirModalPausar(<?= $projeto['ID_Projeto'] ?>)">Pausar</button>
                    </div>

                    <!-- Botão para mostrar/esconder detalhes -->
                    <button class="toggleDetails">Mostrar Detalhes</button>

                    <!-- Detalhes do Projeto (inicialmente oculto) -->
                    <div class="detalhes-projeto collapse">
                        <!-- Tarefas do Projeto -->
                        <div class="tarefas-container">
                            <h3>Tarefas</h3>
                            <ul>
                                <?php foreach ($projeto['tarefas'] as $tarefa) : ?>
                                    <li><?= $tarefa['Nome_tarefa'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <!-- Informações da Equipe -->
                        <div class="equipe-info">
                            <h3>Equipe</h3>
                            <p><strong>Líder da Equipe:</strong> <?= $projeto['equipe']['equipe_lider_id'] ?></p>
                            <p><strong>Membros da Equipe:</strong>
                                <?php foreach ($projeto['equipe']['membros'] as $membro) : ?>
                                    <?= $membro['nome_usuario'] ?>,
                                <?php endforeach; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

        <!-- Modal para Adicionar Projeto -->
        <div id="modalAdicionarProjeto" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionar('modalAdicionarProjeto')">&times;</span>
            <h2>Adicionar Projeto</h2>
            <!-- Formulário de adição de projeto -->
            <form id="formAdicionarProjeto" action="adicionar_projeto.php" method="POST">
                <label for="nomeProjeto">Nome do Projeto:</label>
                <input type="text" id="nomeProjeto" name="nomeProjeto" required>
                
                <label for="tipoProjeto">Tipo do Projeto:</label>
                <input type="text" id="tipoProjeto" name="tipoProjeto" required>
                
                <label for="dataInicio">Data de Início:</label>
                <input type="date" id="dataInicio" name="dataInicio" required>
                
                <label for="dataFim">Data de Término:</label>
                <input type="date" id="dataFim" name="dataFim" required>
                
                <label for="resumoProjeto">Resumo do Projeto:</label>
                <textarea id="resumoProjeto" name="resumoProjeto" required></textarea>
                
                <label for="riscosProjeto">Riscos do Projeto:</label>
                <textarea id="riscosProjeto" name="riscosProjeto" required></textarea>
                
                <label for="orcamentoProjeto">Orçamento do Projeto:</label>
                <input type="number" id="orcamentoProjeto" name="orcamentoProjeto" required>
                
                <label for="recursosProjeto">Recursos do Projeto:</label>
                <textarea id="recursosProjeto" name="recursosProjeto" required></textarea>
                
                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- Modal para Editar Projeto -->
    <div id="modalEditarProjeto" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditar('modalAdicionarProjeto')">&times;</span>
            <h2>Editar Projeto</h2>
            <!-- Formulário de edição de projeto -->
            <form id="formEditarProjeto" action="editar_projeto.php" method="POST">
                <input type="hidden" id="idProjetoEditar" name="idProjetoEditar">
                <label for="nomeProjetoEditar">Nome do Projeto:</label>
                <input type="text" id="nomeProjetoEditar" name="nomeProjetoEditar" required>
                
                <label for="tipoProjetoEditar">Tipo do Projeto:</label>
                <input type="text" id="tipoProjetoEditar" name="tipoProjetoEditar" required>
                
                <label for="dataInicioEditar">Data de Início:</label>
                <input type="date" id="dataInicioEditar" name="dataInicioEditar" required>
                
                <label for="dataFimEditar">Data de Término:</label>
                <input type="date" id="dataFimEditar" name="dataFimEditar" required>
                
                <label for="resumoProjetoEditar">Resumo do Projeto:</label>
                <textarea id="resumoProjetoEditar" name="resumoProjetoEditar" required></textarea>
                
                <label for="riscosProjetoEditar">Riscos do Projeto:</label>
                <textarea id="riscosProjetoEditar" name="riscosProjetoEditar" required></textarea>
                
                <label for="orcamentoProjetoEditar">Orçamento do Projeto:</label>
                <input type="number" id="orcamentoProjetoEditar" name="orcamentoProjetoEditar" required>
                
                <label for="recursosProjetoEditar">Recursos do Projeto:</label>
                <textarea id="recursosProjetoEditar" name="recursosProjetoEditar" required></textarea>
                
                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>

    <!-- Modal para Excluir Projeto -->
    <div id="modalExcluirProjeto" class="modal">
        <div class="modal-content">
            <span class="close" onclick=" fecharModalExcluir('#modalExcluirProjeto')">&times;</span>
            <h2>Excluir Projeto</h2>
            <!-- Formulário de confirmação de exclusão do projeto -->
            <form id="formExcluirProjeto" action="excluir_projeto.php" method="POST">
                <input type="hidden" id="idProjetoExcluir" name="idProjetoExcluir">
                <p>Tem certeza de que deseja excluir este projeto?</p>
                <button type="submit">Sim, Excluir</button>
            </form>
        </div>
    </div>

    <!-- Modal para Pausar Projeto -->
    <div id="modalPausarProjeto" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalPausar('#modalPausarProjeto')">&times;</span>
            <h2>Pausar Projeto</h2>
            <!-- Formulário de confirmação de pausa do projeto -->
            <form id="formPausarProjeto" action="pausar_projeto.php" method="POST">
                <input type="hidden" id="idProjetoPausar" name="idProjetoPausar">
                <p>Tem certeza de que deseja pausar este projeto?</p>
                <button type="submit">Sim, Pausar</button>
            </form>
        </div>
    </div>

    <script src="../js/projetos.js"></script> <!-- Script externo para interatividade -->
</body>

</html>
