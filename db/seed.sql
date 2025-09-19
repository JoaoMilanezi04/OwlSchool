USE olwschool;

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('João da Silva', 'joao.aluno@teste.com', '123456', 'aluno');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Maria Souza', 'maria.prof@teste.com', '123456', 'professor');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Carlos Pereira', 'carlos.resp@teste.com', '123456', 'responsavel');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Admin Master', 'admin@teste.com', '123456', 'admin');



INSERT INTO aluno (usuario_id, ra)
VALUES (1, 'RA2025001');

INSERT INTO professor (usuario_id, telefone)
VALUES (2, '(41) 98888-7777');

INSERT INTO responsavel (usuario_id, telefone)
VALUES (3, '(41) 99999-1234');


INSERT INTO aluno_responsavel (aluno_id, responsavel_id)
VALUES (1, 1);


INSERT INTO turma (nome, turno, serie, professor_id)
VALUES ('1º Ano A', 'Manhã', '1º Ano', 1);


INSERT INTO matricula (aluno_id, turma_id)
VALUES (1, 1);


INSERT INTO disciplina (nome)
VALUES ('Matemática');


INSERT INTO turma_disciplina (turma_id, disciplina_id)
VALUES (1, 1);