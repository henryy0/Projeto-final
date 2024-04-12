<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestão de Equipe</title>
    <!-- Adicione seus links para os arquivos CSS aqui -->
    <link rel="stylesheet" href="../css/equipe.css">
     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="icon" type="image/png" href="../img/logo.png">
</head>

<body>
<div class="container">
        <h1>Gestão de Equipe</h1>

        <!-- Botão para abrir o modal de adicionar equipe -->
        <button onclick="abrirModalAdicionarEquipe()">Adicionar Equipe</button>

        <div class="equipe-container">
            <?php
            // Incluir o arquivo externo com a lógica PHP para obter as equipes
            $equipes = require_once('listar_equipes.php');

            foreach ($equipes as $index => $equipe) :
            ?>
                <div class="equipe-card" id="equipe<?= $index ?>">
                    <h2><?= $equipe['nome'] ?></h2>
                    <p><strong>Líder da Equipe:</strong> <?= $equipe['lider_nome'] ?></p>
                    <p><strong>Email do Líder:</strong> <?= $equipe['lider_email'] ?></p>
                    <p><strong>Descrição:</strong> <?= $equipe['descricao'] ?></p>

                    <!-- Botões de Ação -->
                    <div class="botoes-acao">
                        <button onclick="abrirModalEditarEquipe(<?= $equipe['id'] ?>)">Editar</button>
                        <button onclick="abrirModalExcluirEquipe(<?= $equipe['id'] ?>)">Excluir</button>
                        <button onclick="abrirModalAdicionarMembro(<?= $equipe['id'] ?>)">Adicionar Membro</button>
                        <button onclick="abrirModalAdicionarProjeto(<?= $equipe['id'] ?>)">Adicionar Projeto</button>
                    </div>

                    <!-- Botão para mostrar/esconder detalhes -->
                    <button class="toggleDetails" onclick="toggleDetalhes('detalhesEquipe<?= $index ?>')">Mostrar Detalhes</button>

                    <!-- Detalhes da Equipe -->
                    <div class="detalhes-equipe collapse" id="detalhesEquipe<?= $index ?>">
                        <div class="membros-container">
                            <h3>Membros da Equipe</h3>
                            <ul>
                                <?php foreach ($equipe['membros'] as $membro) : ?>
                                    <li><?= $membro['nome_usuario'] ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>

                        <div class="projetos-container">
                            <h3>Projetos Atribuídos</h3>
                            <ul>
                                <?php if (!empty($equipe['projetos']) && is_array($equipe['projetos'])) : ?>
                                    <?php foreach ($equipe['projetos'] as $projeto) : ?>
                                        <li><?= $projeto ?></li>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <li>Nenhum projeto atribuído</li>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>


    <!-- Modal de adicionar equipe -->
    <div id="modalAdicionarEquipe" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionarEquipe('modalAdicionarEquipe')">&times;</span>
            <h2>Adicionar Nova Equipe</h2>
            <form id="formAdicionarEquipe" action="criar_equipe.php" method="POST">
                <label for="nomeEquipe">Nome da Equipe:</label>
                <input type="text" id="nomeEquipe" name="nomeEquipe" required>

                <!-- Dropdown para selecionar o líder da equipe -->
                <label for="liderEquipe">Líder da Equipe:</label>
                <select id="liderEquipe" name="liderEquipe" required>
                    <?php include 'opcoes_lider.php'; ?>
                </select>

                <!-- Multiselect para selecionar os membros -->
                <label for="membrosEquipe">Membros da Equipe:</label>
                <select id="membrosEquipe" name="membrosEquipe[]" multiple required>
                    <?php include 'opcoes_membros.php'; ?>
                </select>

                <!-- Multiselect para selecionar os projetos -->
                <label for="projetosEquipe">Projetos da Equipe:</label>
                <select id="projetosEquipe" name="projetosEquipe[]" multiple required>
                    <?php include '../projetos/opcoes_projetos.php'; ?>
                </select>

                <label for="descricaoEquipe">Descrição da Equipe:</label>
                <textarea id="descricaoEquipe" name="descricaoEquipe"></textarea>

                <!-- Botão para enviar o formulário -->
                <button type="submit">Criar Equipe</button>
            </form>
        </div>
    </div>


    <!-- Modal de editar equipe -->
    <div id="modalEditarEquipe" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalEditarEquipe('modalEditarEquipe')">&times;</span>
            <h2>Editar Equipe</h2>
            <form id="formEditarEquipe" action="editar_equipe.php" method="POST">
                <input type="hidden" id="idEquipeEditar" name="idEquipeEditar">

                <label for="nomeEquipeEditar">Novo Nome da Equipe:</label>
                <input type="text" id="nomeEquipeEditar" name="nomeEquipeEditar" required>

                <!-- Dropdown para selecionar o novo líder da equipe -->
                <label for="liderEquipeEditar">Novo Líder da Equipe:</label>
                <select id="liderEquipeEditar" name="liderEquipeEditar" required>
                    <?php include 'opcoes_lider.php'; ?>
                </select>

                <!-- Multiselect para selecionar os membros -->
                <label for="membrosEquipeEditar">Membros da Equipe:</label>
                <select id="membrosEquipeEditar" name="membrosEquipeEditar[]" multiple required>
                    <?php include 'opcoes_membros.php'; ?>
                </select>

                <!-- Multiselect para selecionar os projetos -->
                <label for="projetosEquipeEditar">Projetos da Equipe:</label>
                <select id="projetosEquipeEditar" name="projetosEquipeEditar[]" multiple required>
                    <?php include '../projetos/opcoes_projetos.php'; ?>
                </select>

                <label for="descricaoEquipe">Descrição da Equipe:</label>
                <textarea id="descricaoEquipe" name="descricaoEquipe"></textarea>


                <!-- Botão para enviar o formulário -->
                <button type="submit">Salvar Alterações</button>
            </form>
        </div>
    </div>


    <!-- Modal de excluir equipe -->
    <div id="modalExcluirEquipe" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalExcluirEquipe('modalExcluirEquipe')">&times;</span>
            <h2>Excluir Equipe</h2>
            <p>Deseja realmente excluir esta equipe?</p>
            <form id="formExcluirEquipe" action="excluir_equipe.php" method="POST">
                <input type="hidden" id="idEquipeExcluir" name="idEquipeExcluir">

                <!-- Botão para confirmar a exclusão -->
                <button type="submit">Sim, Excluir</button>
            </form>
        </div>
    </div>


    <!-- Modal de adicionar novo membro -->
    <div id="modalAdicionarMembro" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionarMembro('modalAdicionarMembro')">&times;</span>
            <h2>Adicionar Novo Membro</h2>
            <form id="formAdicionarMembro" action="adicionar_membro.php" method="POST">
                <!-- Dropdown para selecionar o membro -->
                <label for="nomeMembro">Selecionar Membro:</label>
                <select id="nomeMembro" name="nomeMembro" required>
                    <?php include 'opcoes_membros.php'; ?>
                </select>

                <!-- Dropdown para selecionar a equipe -->
                <label for="equipeMembro">Equipe:</label>
                <select id="equipeMembro" name="equipeMembro" required>
                    <?php include 'opcoes_equipe.php'; ?>
                </select>

                <!-- Botão para enviar o formulário -->
                <button type="submit">Adicionar Membro</button>
            </form>
        </div>
    </div>

    <!-- Modal para Adicionar Projeto -->
    <div id="modalAdicionarProjeto" class="modal">
        <div class="modal-content">
            <span class="close" onclick="fecharModalAdicionarProjeto('modalAdicionarProjeto')">&times;</span>
            <h2>Adicionar Projeto</h2>
            <!-- Formulário de adição de projeto -->
            <form id="formAdicionarProjeto" action="../projetos/adicionar_projeto.php" method="POST">
                <input type="hidden" id="equipeProjeto" name="equipeProjeto">

                <!-- Radio button para escolher entre criar novo projeto ou selecionar existente -->
                <label for="criarOuSelecionarProjeto">Criar novo projeto ou selecionar existente:</label>
                <input type="radio" id="criarProjeto" name="criarOuSelecionarProjeto" value="criar" onclick="mostrarCamposNovoProjeto()"> Criar novo
                <input type="radio" id="selecionarProjeto" name="criarOuSelecionarProjeto" value="selecionar" onclick="mostrarDropdownProjetos()"> Selecionar existente

                <!-- Campos para criar novo projeto (inicialmente oculto) -->
                <div id="camposNovoProjeto" style="display: none;">
                    <!-- Adicione aqui os campos para criar um novo projeto -->
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
                </div>

                <!-- Multiselect para selecionar os projetos existentes (inicialmente oculto) -->
                <div id="dropdownProjetos" style="display: none;">
                    <label for="projetosExistente">Projetos Existentes:</label>
                    <select id="projetosExistente" name="projetosExistente[]" multiple required>
                        <?php include '../projetos/opcoes_projetos.php'; ?>
                    </select>
                </div>
                
                <!-- Botão para enviar o formulário -->
                <button type="submit">Adicionar</button>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <!-- Bootstrap JavaScript (necessário para o Collapse) -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>

    <!-- Adicione seus scripts JavaScript aqui -->
    <script src="../js/equipe.js"></script>
</body>

</html>
