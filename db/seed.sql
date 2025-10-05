USE owl_school;

-- USUÁRIOS
INSERT INTO usuario (nome, email, senha, tipo_usuario) VALUES
('João da Silva',   'joao.aluno@teste.com',   '123456', 'aluno'),
('Ana Santos',      'ana.aluno@teste.com',    '123456', 'aluno'),
('Bruno Lima',      'bruno.aluno@teste.com',  '123456', 'aluno'),
('Carlos Pereira',  'carlos.resp@teste.com',  '123456', 'responsavel'),
('Paulo Santos',    'paulo.resp@teste.com',   '123456', 'responsavel'),
('Cláudia Lima',    'claudia.resp@teste.com', '123456', 'responsavel'),
('Maria Souza',     'maria.prof@teste.com',   '123456', 'professor'),
('Admin Master',    'admin@teste.com',        '123456', 'admin');

-- ALUNOS
INSERT INTO aluno (usuario_id, faltas, advertencia) VALUES
(1, 0, NULL),
(2, 0, NULL),
(3, 0, NULL);

-- RESPONSÁVEIS
INSERT INTO responsavel (usuario_id, telefone) VALUES
(4, '(41) 99999-1234'),
(5, '(41) 98888-2222'),
(6, '(41) 97777-3333');

-- PROFESSOR
INSERT INTO professor (usuario_id, telefone) VALUES
(7, '(41) 98888-7777');

-- VÍNCULO ALUNO-RESPONSÁVEL
INSERT INTO aluno_responsavel (aluno_id, responsavel_id) VALUES
(1, 4),
(2, 5),
(3, 6);
