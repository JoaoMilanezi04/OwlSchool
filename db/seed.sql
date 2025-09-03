-- Dados de teste (alunos, notas, etc.)

USE olwschool;

-- Inserir um aluno
INSERT INTO usuario (nome, email, senha_hash, tipo_usuario)
VALUES ('João da Silva', 'joao.aluno@teste.com', '123456', 'aluno');

-- Inserir um professor
INSERT INTO usuario (nome, email, senha_hash, tipo_usuario)
VALUES ('Maria Souza', 'maria.prof@teste.com', '123456', 'professor');

-- Inserir um responsável
INSERT INTO usuario (nome, email, senha_hash, tipo_usuario)
VALUES ('Carlos Pereira', 'carlos.resp@teste.com', '123456', 'responsavel');

-- Inserir um admin
INSERT INTO usuario (nome, email, senha_hash, tipo_usuario)
VALUES ('Admin Master', 'admin@teste.com', '123456', 'admin');
