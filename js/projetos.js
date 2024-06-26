// Função para abrir o modal de adicionar projeto
function abrirModalAdicionar() {
    document.getElementById('modalAdicionarProjeto').style.display = 'block';
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

// Função para abrir o modal de excluir projeto e definir o ID do projeto
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

// Função para remover acentos de uma string
function removerAcentos(s) {
    return s.normalize("NFD").replace(/[\u0300-\u036f]/g, "");
}

// Função para filtrar os projetos com base no status
function filtrarProjetos(status) {
    const projetos = document.querySelectorAll('.projeto-card');
    const statusLowerCase = status.toLowerCase(); // Converter para minúsculas

    projetos.forEach(projeto => {
        const projetoStatus = projeto.getAttribute('data-status').toLowerCase(); // Convertendo para minúsculas para comparação
        const projetoStatusSemAcento = removerAcentos(projetoStatus);
        const statusSelecionadoSemAcento = removerAcentos(statusLowerCase);
        
        if (statusSelecionadoSemAcento === 'todos' || projetoStatusSemAcento === statusSelecionadoSemAcento) {
            projeto.style.display = 'block';
        } else if (statusSelecionadoSemAcento === 'concluido' && projetoStatusSemAcento === 'concluído') {
            projeto.style.display = 'block';
        } else {
            projeto.style.display = 'none';
        }
    });
}

// Adicione este código em algum lugar onde você inicializa sua aplicação para garantir que o filtro seja aplicado corretamente
document.addEventListener('DOMContentLoaded', function() {
    const filtroStatus = document.getElementById('filtroStatus');
    filtroStatus.addEventListener('change', function() {
        const statusSelecionado = filtroStatus.value;
        filtrarProjetos(statusSelecionado);
    });
});
