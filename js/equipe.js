// Função para abrir o modal de adicionar equipe
function abrirModalAdicionarEquipe() {
    document.getElementById('modalAdicionarEquipe').style.display = 'block';
}

// Função para fechar o modal de adicionar equipe
function fecharModalAdicionarEquipe() {
    document.getElementById('modalAdicionarEquipe').style.display = 'none';
}

// Função para abrir o modal de editar equipe e definir o ID da equipe
function abrirModalEditarEquipe(idEquipe) {
    // Define o valor do campo oculto idEquipeEditar no formulário
    document.getElementById('idEquipeEditar').value = idEquipe;
    // Exibe o modal
    document.getElementById('modalEditarEquipe').style.display = 'block';
}

// Função para fechar o modal de editar equipe
function fecharModalEditarEquipe() {
    document.getElementById('modalEditarEquipe').style.display = 'none';
}

// Função para abrir o modal de excluir equipe e definir o ID da equipe
function abrirModalExcluirEquipe(idEquipe) {
    // Define o valor do campo oculto idEquipeExcluir no formulário
    document.getElementById('idEquipeExcluir').value = idEquipe;
    // Exibe o modal
    document.getElementById('modalExcluirEquipe').style.display = 'block';
}

// Função para fechar o modal de excluir equipe
function fecharModalExcluirEquipe() {
    document.getElementById('modalExcluirEquipe').style.display = 'none';
}

// Função para abrir o modal de adicionar membro à equipe e definir o ID da equipe
function abrirModalAdicionarMembro(idEquipe) {
    // Define o valor do campo oculto equipeMembro no formulário
    document.getElementById('equipeMembro').value = idEquipe;
    // Exibe o modal
    document.getElementById('modalAdicionarMembro').style.display = 'block';
}

// Função para fechar o modal de adicionar membro à equipe
function fecharModalAdicionarMembro() {
    document.getElementById('modalAdicionarMembro').style.display = 'none';
}

// Função para abrir o modal de adicionar projeto
function abrirModalAdicionarProjeto(idEquipe) {
    // Define o valor do campo oculto equipeProjeto no formulário
    document.getElementById('equipeProjeto').value = idEquipe;
    // Exibe o modal
    document.getElementById('modalAdicionarProjeto').style.display = 'block';
}

// Função para fechar o modal de adicionar projeto
function fecharModalAdicionarProjeto() {
    document.getElementById('modalAdicionarProjeto').style.display = 'none';
}

function mostrarCamposNovoProjeto() {
    document.getElementById("camposNovoProjeto").style.display = "block";
    document.getElementById("dropdownProjetos").style.display = "none";
}

function mostrarDropdownProjetos() {
    document.getElementById("camposNovoProjeto").style.display = "none";
    document.getElementById("dropdownProjetos").style.display = "block";
}


function toggleDetalhes(id) {
    var detalhes = document.getElementById(id);
    detalhes.classList.toggle('show');
}

