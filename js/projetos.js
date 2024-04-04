// Função para abrir o modal de adicionar projeto
function abrirModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'block';
}

// Função para fechar o modal de adicionar projeto
function fecharModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'none';
}

// Função para abrir o modal de pausar projeto e definir o ID do projeto no campo oculto
function abrirModalPausar(idProjeto, statusProjeto) {
    // Define o valor do campo oculto id_projeto no formulário
    document.getElementById('idProjeto').value = idProjeto;
    // Define o valor do campo oculto status_projeto no formulário
    document.getElementById('statusProjeto').value = statusProjeto;
    // Exibe o modal
    document.getElementById('modalPausarProjeto').style.display = 'block';
}

// Função para fechar o modal de pausar projeto
function fecharModalPausar() {
    document.getElementById('modalPausarProjeto').style.display = 'none';
}

// Função para abrir o modal de excluir projeto e definir o ID do projeto e status
function abrirModalExcluir(idProjeto, statusProjeto) {
    // Define o valor do campo oculto idProjetoExcluir no formulário
    document.getElementById('idProjetoExcluir').value = idProjeto;
    // Exibe o modal
    document.getElementById('modalExcluirProjeto').style.display = 'block';
}

// Função para fechar o modal de excluir projeto
function fecharModalExcluir() {
    document.getElementById('modalExcluirProjeto').style.display = 'none';
}

// Função para abrir o modal de editar projeto
function abrirModalEditar(idProjeto) {
    document.getElementById('modalEditarProjeto').style.display = 'block';
}

// Função para fechar o modal de editar projeto
function fecharModalEditar() {
    document.getElementById('modalEditarProjeto').style.display = 'none';
}

// Função para filtrar os projetos com base no status
function filtrarProjetos(status) {
    const projetos = document.querySelectorAll('.projeto-card');
    projetos.forEach(projeto => {
        const projetoStatus = projeto.getAttribute('data-status').toLowerCase(); // Convertendo para minúsculas para comparação
        if (status === 'todos' || projetoStatus === status) {
            projeto.style.display = 'block';
        } else if (status === 'pausado' && projetoStatus === status) {
            projeto.style.display = 'block'; // Exibe os projetos pausados
        } else {
            projeto.style.display = 'none';
        }
    });
}

// Event listener para mostrar/esconder detalhes
document.addEventListener("DOMContentLoaded", function() {
    var toggleButtons = document.querySelectorAll(".toggleDetails");
    toggleButtons.forEach(toggleButton => {
        toggleButton.addEventListener("click", function() {
            var details = this.parentNode.querySelector('.detalhes-projeto');
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
                this.textContent = "Esconder Detalhes";
            } else {
                details.style.display = "none";
                this.textContent = "Mostrar Detalhes";
            }
        });
    });
});
