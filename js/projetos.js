// Função para abrir o modal de adicionar projeto
function abrirModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'block';
}

// Função para fechar o modal de adicionar projeto
function fecharModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'none';
}

// Função para abrir o modal de pausar projeto
function abrirModalPausar(idProjeto) {
    document.getElementById('modalPausarProjeto').style.display = 'block';
}

// Função para fechar o modal de pausar projeto
function fecharModalPausar() {
    document.getElementById('modalPausarProjeto').style.display = 'none';
}

// Função para abrir o modal de excluir projeto
function abrirModalExcluir(idProjeto) {
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
        const projetoStatus = projeto.getAttribute('data-status');
        if (status === 'todos' || projetoStatus === status) {
            projeto.style.display = 'block';
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