CREATE DATABASE IF NOT EXISTS mathplay CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE mathplay;

CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('aluno', 'admin') NOT NULL DEFAULT 'aluno',
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE progresso (
    usuario_id INT PRIMARY KEY,
    xp INT NOT NULL DEFAULT 0,
    nivel INT NOT NULL DEFAULT 1,
    percentual INT NOT NULL DEFAULT 0,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE resultados (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    jogo VARCHAR(80) NOT NULL,
    dificuldade ENUM('facil', 'medio', 'dificil') NOT NULL DEFAULT 'facil',
    pontuacao INT NOT NULL DEFAULT 0,
    acertos INT NOT NULL DEFAULT 0,
    erros INT NOT NULL DEFAULT 0,
    jogado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

CREATE TABLE conquistas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL UNIQUE,
    icone VARCHAR(10) NOT NULL,
    descricao VARCHAR(255) NOT NULL
);

CREATE TABLE usuario_conquistas (
    usuario_id INT NOT NULL,
    conquista_id INT NOT NULL,
    conquistada_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (usuario_id, conquista_id),
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (conquista_id) REFERENCES conquistas(id) ON DELETE CASCADE
);

INSERT INTO conquistas (nome, icone, descricao) VALUES
('Primeiro Passo', '🏆', 'Complete seu primeiro jogo.'),
('Sequência Perfeita', '🔥', 'Acerte cinco respostas na mesma partida.'),
('Mestre da Matemática', '🧠', 'Alcance 20 acertos em suas partidas.'),
('Sem Errar', '🎯', 'Finalize uma partida sem erros.'),
('Jogador Frequente', '⭐', 'Complete cinco partidas.');
