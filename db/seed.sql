-- Dados de teste (alunos, notas, etc.)

USE olwschool;

-- Inserir um aluno
INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('João da Silva', 'joao.aluno@teste.com', '123456', 'aluno');

-- Inserir um professor
INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Maria Souza', 'maria.prof@teste.com', '123456', 'professor');

-- Inserir um responsável
INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Carlos Pereira', 'carlos.resp@teste.com', '123456', 'responsavel');

-- Inserir um admin
INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Admin Master', 'admin@teste.com', '123456', 'admin');



-- João é aluno
INSERT INTO aluno (usuario_id, ra)
VALUES (1, 'RA2025001');

-- Maria é professora
INSERT INTO professor (usuario_id, titulacao)
VALUES (2, 'Mestre em Matemática');

-- Carlos é responsável
INSERT INTO responsavel (usuario_id, telefone)
VALUES (3, '(41) 99999-1234');



-- Criar uma relação entre aluno e responsável
INSERT INTO aluno_responsavel (aluno_id, responsavel_id)
VALUES (1, 1);

