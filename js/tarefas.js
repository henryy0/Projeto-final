// Função para abrir o modal de adicionar tarefa
function abrirModalAdicionarTarefa() {
    document.getElementById('modalAdicionarTarefa').style.display = 'block';
}

// Função para fechar o modal de adicionar tarefa
function fecharModalAdicionarTarefa() {
    document.getElementById('modalAdicionarTarefa').style.display = 'none';
}

// Função para abrir o modal de editar tarefa
function abrirModalEditarTarefa() {
    document.getElementById('modalEditarTarefa').style.display = 'block';
}

// Função para fechar o modal de editar tarefa
function fecharModalEditarTarefa() {
    document.getElementById('modalEditarTarefa').style.display = 'none';
}

// Função para abrir o modal de pausar tarefa
function abrirModalPausarTarefa(idTarefa) {
    document.getElementById('idTarefaPausar').value = idTarefa;
    document.getElementById('modalPausarTarefa').style.display = 'block';
}

// Função para fechar o modal de pausar tarefa
function fecharModalPausarTarefa() {
    document.getElementById('modalPausarTarefa').style.display = 'none';
}

// Função para abrir o modal de concluir tarefa
function abrirModalConcluirTarefa(idTarefa) {
    document.getElementById('idTarefaConcluir').value = idTarefa;
    document.getElementById('modalConcluirTarefa').style.display = 'block';
}

// Função para fechar o modal de concluir tarefa
function fecharModalConcluirTarefa() {
    document.getElementById('modalConcluirTarefa').style.display = 'none';
}

// Função para abrir o modal de excluir tarefa
function abrirModalExcluirTarefa(idTarefa) {
    document.getElementById('idTarefaExcluir').value = idTarefa;
    document.getElementById('modalExcluirTarefa').style.display = 'block';
}

// Função para fechar o modal de excluir tarefa
function fecharModalExcluirTarefa() {
    document.getElementById('modalExcluirTarefa').style.display = 'none';
}

// Função para filtrar as tarefas com base no status
function filtrarTarefas(status) {
    const tarefas = document.querySelectorAll('.tarefa-card');
    tarefas.forEach(tarefa => {
        const tarefaStatus = tarefa.getAttribute('data-status').toLowerCase(); // Convertendo para minúsculas
        if (status.toLowerCase() === 'todos' || tarefaStatus === status.toLowerCase()) {
            tarefa.style.display = 'block';
        } else if (status.toLowerCase() === 'concluido' && tarefaStatus === 'concluído') {
            tarefa.style.display = 'block';
        } else {
            tarefa.style.display = 'none';
        }
    });
}

// Adicione este código em algum lugar onde você inicializa sua aplicação para garantir que o filtro seja aplicado corretamente
document.addEventListener('DOMContentLoaded', function() {
    const filtroStatus = document.getElementById('filtroStatus');
    filtroStatus.addEventListener('change', function() {
        const statusSelecionado = filtroStatus.value;
        filtrarTarefas(statusSelecionado);
    });
});
