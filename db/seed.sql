USE owl_school;

-- =========================
-- USUÁRIOS
-- =========================
INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('João da Silva', 'joao.aluno@teste.com', '123456', 'aluno');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Ana Santos', 'ana.aluno@teste.com', '123456', 'aluno');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Bruno Lima', 'bruno.aluno@teste.com', '123456', 'aluno');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Carlos Pereira', 'carlos.resp@teste.com', '123456', 'responsavel');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Paulo Santos', 'paulo.resp@teste.com', '123456', 'responsavel');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Cláudia Lima', 'claudia.resp@teste.com', '123456', 'responsavel');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Maria Souza', 'maria.prof@teste.com', '123456', 'professor');

INSERT INTO usuario (nome, email, senha, tipo_usuario)
VALUES ('Admin Master', 'admin@teste.com', '123456', 'admin');

-- =========================
-- ALUNOS
-- =========================
INSERT INTO aluno (usuario_id, ra)
VALUES (1, 'RA2025001');

INSERT INTO aluno (usuario_id, ra)
VALUES (2, 'RA2025002');

INSERT INTO aluno (usuario_id, ra)
VALUES (3, 'RA2025003');

-- =========================
-- RESPONSÁVEIS
-- =========================
INSERT INTO responsavel (usuario_id, telefone)
VALUES (4, '(41) 99999-1234');

INSERT INTO responsavel (usuario_id, telefone)
VALUES (5, '(41) 98888-2222');

INSERT INTO responsavel (usuario_id, telefone)
VALUES (6, '(41) 97777-3333');

-- =========================
-- PROFESSOR
-- =========================
INSERT INTO professor (usuario_id, telefone)
VALUES (7, '(41) 98888-7777');

-- =========================
-- VÍNCULO ALUNO-RESPONSÁVEL
-- =========================
INSERT INTO aluno_responsavel (aluno_id, responsavel_id)
VALUES (1, 1);

INSERT INTO aluno_responsavel (aluno_id, responsavel_id)
VALUES (2, 2);

INSERT INTO aluno_responsavel (aluno_id, responsavel_id)
VALUES (3, 3);

-- =========================
-- TURMA
-- =========================
INSERT INTO turma (nome, turno, serie, professor_id_responsavel)
VALUES ('1º Ano A', 'Manhã', '1º Ano', 1);

-- =========================
-- MATRÍCULAS
-- =========================
INSERT INTO matricula (aluno_id, turma_id, data_matricula)
VALUES (1, 1, '2025-02-10');

INSERT INTO matricula (aluno_id, turma_id, data_matricula)
VALUES (2, 1, '2025-02-10');

INSERT INTO matricula (aluno_id, turma_id, data_matricula)
VALUES (3, 1, '2025-02-10');

-- =========================
-- DISCIPLINAS
-- =========================
INSERT INTO disciplina (nome) VALUES ('Matemática');
INSERT INTO disciplina (nome) VALUES ('Português');
INSERT INTO disciplina (nome) VALUES ('Ciências');
INSERT INTO disciplina (nome) VALUES ('História');
INSERT INTO disciplina (nome) VALUES ('Geografia');

-- =========================
-- LIGAR TURMA ÀS DISCIPLINAS
-- =========================
INSERT INTO turma_disciplina (turma_id, disciplina_id) VALUES (1, 1);
INSERT INTO turma_disciplina (turma_id, disciplina_id) VALUES (1, 2);
INSERT INTO turma_disciplina (turma_id, disciplina_id) VALUES (1, 3);
INSERT INTO turma_disciplina (turma_id, disciplina_id) VALUES (1, 4);
INSERT INTO turma_disciplina (turma_id, disciplina_id) VALUES (1, 5);
