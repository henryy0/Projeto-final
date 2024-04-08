CREATE DATABASE IF NOT EXISTS SistemaDeGerenciamento;
USE SistemaDeGerenciamento;

CREATE TABLE IF NOT EXISTS Usuario (
    id_usuario INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    nome_usuario VARCHAR(50) NOT NULL,
    sobrenome_usuario VARCHAR(50),
    email_usuario VARCHAR(100),
    telefone_usuario VARCHAR(20),
    login_usuario VARCHAR(30) NOT NULL UNIQUE,
    senha_usuario VARCHAR(100) NOT NULL,
    foto_usuario VARCHAR(255),
    ultimo_acesso DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS Projeto (
    ID_Projeto INT AUTO_INCREMENT PRIMARY KEY,
    Nome_Projeto VARCHAR(100) UNIQUE NOT NULL,
    Tipo_Projeto VARCHAR(100) NOT NULL,
    Data_inicio_Projeto DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Data_Fim_Projeto DATETIME,
    Status_Projeto VARCHAR(20) NOT NULL,
    Resumo_Projeto TEXT NOT NULL,
    Riscos_Projeto TEXT NOT NULL,
    Orcamento_Projeto DECIMAL(10, 2) NOT NULL,
    Recursos_Projeto TEXT NOT NULL,
    Porcentagem_Conclusao DECIMAL(5, 2), -- Adicionando a coluna ausente
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
);

CREATE TABLE IF NOT EXISTS Equipe (
    equipe_id INT AUTO_INCREMENT PRIMARY KEY,
    equipe_nome VARCHAR(100) NOT NULL,
    equipe_descricao VARCHAR(255),
    equipe_lider_id INT,
    lider_email VARCHAR(100),
    projeto_atribuido_id INT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipe_lider_id) REFERENCES Usuario(id_usuario), -- Adicionando chave estrangeira para líder da equipe
    FOREIGN KEY (projeto_atribuido_id) REFERENCES Projeto(ID_Projeto) -- Adicionando chave estrangeira para projeto atribuído
);

CREATE TABLE IF NOT EXISTS Equipe_Projeto (
    id INT AUTO_INCREMENT PRIMARY KEY,
    equipe_id INT NOT NULL,
    projeto_id INT NOT NULL,
    FOREIGN KEY (equipe_id) REFERENCES Equipe(equipe_id),
    FOREIGN KEY (projeto_id) REFERENCES Projeto(ID_Projeto)
);

select * from equipe;

CREATE TABLE IF NOT EXISTS Tarefa (
    ID_tarefa INT AUTO_INCREMENT PRIMARY KEY,
    Projeto_tarefa INT NOT NULL,
    Nome_tarefa VARCHAR(100) NOT NULL,
    Data_inicio_Tarefa DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL,
    Data_Fim_Tarefa DATETIME,
    Obs_tarefa TEXT NOT NULL,
    Status_tarefa VARCHAR(20) NOT NULL,
    Responsavel_tarefa INT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (Projeto_tarefa) REFERENCES Projeto(ID_Projeto),
    FOREIGN KEY (Responsavel_tarefa) REFERENCES Usuario(id_usuario)
);

CREATE TABLE IF NOT EXISTS Equipe_Membro (
    id_equipe_membro INT AUTO_INCREMENT PRIMARY KEY,
    equipe_id INT,
    usuario_id INT,
    data_criacao DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (equipe_id) REFERENCES Equipe(equipe_id),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(id_usuario)
);

CREATE TABLE IF NOT EXISTS Calendario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    titulo VARCHAR(255) NOT NULL,
    Data DATE NOT NULL,
    data_criacao DATETIME NOT NULL,
    modificado DATETIME NOT NULL,
    status_calendario TINYINT(1) NOT NULL DEFAULT 1 COMMENT '1=Ativo | 0=Inativo'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;




CREATE TABLE IF NOT EXISTS Conversas (
    id_conversa INT AUTO_INCREMENT PRIMARY KEY,
    usuario_1 INT NOT NULL,
    usuario_2 INT NOT NULL,
    FOREIGN KEY (usuario_1) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (usuario_2) REFERENCES Usuario(id_usuario)
);

CREATE TABLE IF NOT EXISTS Mensagens (
    id_mensagem INT AUTO_INCREMENT PRIMARY KEY,
    de_id INT NOT NULL,
    para_id INT NOT NULL,
    mensagem TEXT NOT NULL,
    visualizada TINYINT(1) NOT NULL DEFAULT 0,
    criado_em DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (de_id) REFERENCES Usuario(id_usuario),
    FOREIGN KEY (para_id) REFERENCES Usuario(id_usuario)
);