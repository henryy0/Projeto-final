// Função para abrir o modal de adicionar tarefa
function abrirModalAdicionarTarefa() {
    document.getElementById('modalAdicionarTarefa').style.display = 'block';
}

// Função para fechar o modal de adicionar projeto
function fecharModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'none';
}

// Função para abrir o modal de pausar projeto e definir o ID do projeto no campo oculto
function abrirModalPausar(idProjeto) {
    // Define o valor do campo oculto idProjetoPausar no formulário
    document.getElementById('idProjetoPausar').value = idProjeto;
    // Exibe o modal
    document.getElementById('modalPausarProjeto').style.display = 'block';
}


// Função para fechar o modal de pausar projeto
function fecharModalPausar() {
    document.getElementById('modalPausarProjeto').style.display = 'none';
}


// Função para abrir o modal de excluir projeto e definir o ID do projeto e status
function abrirModalExcluir(idProjeto) {
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
// Função para abrir o modal de editar projeto e definir o ID do projeto
function abrirModalEditar(idProjeto) {
    // Define o valor do campo oculto idProjetoEditar no formulário
    document.getElementById('idProjetoEditar').value = idProjeto;
    // Exibe o modal
    document.getElementById('modalEditarProjeto').style.display = 'block';
}


// Função para fechar o modal de editar projeto
function fecharModalEditar() {
    document.getElementById('modalEditarProjeto').style.display = 'none';
}

// Função para filtrar os projetos com base no status
function filtrarProjetos(status) {
    const projetos = document.querySelectorAll('.projeto-card');
    const statusLowerCase = status.toLowerCase(); // Converter para minúsculas

    projetos.forEach(projeto => {
        const projetoStatus = projeto.getAttribute('data-status').toLowerCase(); // Convertendo para minúsculas para comparação
        if (statusLowerCase === 'todos' || projetoStatus === statusLowerCase) {
            projeto.style.display = 'block';
        } else if (statusLowerCase === 'em andamento' && projetoStatus === 'em andamento') {
            projeto.style.display = 'block'; // Exibe os projetos em andamento
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

