// Função para abrir o modal de adicionar tarefa
function abrirModalAdicionarTarefa() {
    document.getElementById('modalAdicionarTarefa').style.display = 'block';
}

// Função para fechar o modal de adicionar tarefa
function fecharModalAdicionarTarefa() {
    document.getElementById('modalAdicionarTarefa').style.display = 'none';
}

// Função para abrir o modal de editar tarefa
function abrirModalEditarTarefa(idTarefa) {
    // Aqui você pode adicionar lógica para preencher o formulário de edição com os dados da tarefa selecionada
    document.getElementById('modalEditarTarefa').style.display = 'block';
}

// Função para fechar o modal de editar tarefa
function fecharModalEditarTarefa() {
    document.getElementById('modalEditarTarefa').style.display = 'none';
}

// Função para abrir o modal de excluir tarefa
function abrirModalExcluirTarefa(idTarefa) {
    // Defina o ID da tarefa a ser excluída no campo oculto do formulário de exclusão
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
        const tarefaStatus = tarefa.getAttribute('data-status');
        if (status === 'todos' || tarefaStatus === status) {
            tarefa.style.display = 'block';
        } else {
            tarefa.style.display = 'none';
        }
    });
}

// Função para marcar uma tarefa como concluída
function concluirTarefa(idTarefa) {
    // Aqui você pode adicionar lógica para marcar a tarefa como concluída
    console.log('Tarefa concluída com sucesso:', idTarefa);
}
