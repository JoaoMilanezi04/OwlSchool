CREATE DATABASE IF NOT EXISTS owl_school;
USE owl_school;

CREATE TABLE IF NOT EXISTS usuario (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(120) NOT NULL UNIQUE,
  senha VARCHAR(100) NOT NULL,
  tipo_usuario ENUM('aluno','professor','responsavel','admin') NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS aluno (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  ra VARCHAR(40) NOT NULL UNIQUE,
  FOREIGN KEY (usuario_id) REFERENCES usuario(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS professor (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  telefone VARCHAR(30) NOT NULL UNIQUE,
  FOREIGN KEY (usuario_id) REFERENCES usuario(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS responsavel (
  id INT AUTO_INCREMENT PRIMARY KEY,
  usuario_id INT NOT NULL,
  telefone VARCHAR(30) NOT NULL UNIQUE,
  FOREIGN KEY (usuario_id) REFERENCES usuario(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS aluno_responsavel (
  aluno_id INT NOT NULL,
  responsavel_id INT NOT NULL,
  PRIMARY KEY (aluno_id, responsavel_id),
  FOREIGN KEY (aluno_id) REFERENCES aluno(id),
  FOREIGN KEY (responsavel_id) REFERENCES responsavel(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS turma (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(60) NOT NULL,
  turno VARCHAR(20) NOT NULL,
  serie VARCHAR(20) NOT NULL,
  professor_id_responsavel INT NULL,
  FOREIGN KEY (professor_id_responsavel) REFERENCES professor(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS disciplina (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nome VARCHAR(80) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS turma_disciplina (
  turma_id INT NOT NULL,
  disciplina_id INT NOT NULL,
  PRIMARY KEY (turma_id, disciplina_id),
  FOREIGN KEY (turma_id) REFERENCES turma(id),
  FOREIGN KEY (disciplina_id) REFERENCES disciplina(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS professor_turma (
  professor_id INT NOT NULL,
  turma_id INT NOT NULL,
  PRIMARY KEY (professor_id, turma_id),
  FOREIGN KEY (professor_id) REFERENCES professor(id),
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS matricula (
  id INT AUTO_INCREMENT PRIMARY KEY,
  aluno_id INT NOT NULL,
  turma_id INT NOT NULL,
  data_matricula DATE NOT NULL,
  UNIQUE KEY uq_matricula (aluno_id, turma_id),
  FOREIGN KEY (aluno_id) REFERENCES aluno(id),
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;

-- =========================
-- FUNÇÃO 1 — CHAMADA
-- =========================
CREATE TABLE IF NOT EXISTS chamada (
  id INT AUTO_INCREMENT PRIMARY KEY,
  turma_id INT NOT NULL,
  data DATE NOT NULL,
  observacao VARCHAR(255) NULL,
  UNIQUE KEY uq_chamada_dia (turma_id, data),
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS chamada_item (
  chamada_id INT NOT NULL,
  aluno_id INT NOT NULL,
  status ENUM('presente','falta','atraso','justificada') NOT NULL,
  PRIMARY KEY (chamada_id, aluno_id),
  FOREIGN KEY (chamada_id) REFERENCES chamada(id),
  FOREIGN KEY (aluno_id) REFERENCES aluno(id)
) ENGINE=InnoDB;

-- =========================
-- FUNÇÃO 2 — PROVA E NOTAS
-- =========================
CREATE TABLE IF NOT EXISTS prova (
  id INT AUTO_INCREMENT PRIMARY KEY,
  turma_id INT NOT NULL,
  titulo VARCHAR(120) NOT NULL,
  data DATE NOT NULL,
  observacao VARCHAR(255) NULL,
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS prova_nota (
  prova_id INT NOT NULL,
  aluno_id INT NOT NULL,
  nota DECIMAL(5,2) NOT NULL,
  PRIMARY KEY (prova_id, aluno_id),
  FOREIGN KEY (prova_id) REFERENCES prova(id),
  FOREIGN KEY (aluno_id) REFERENCES aluno(id)
) ENGINE=InnoDB;

-- =========================
-- FUNÇÃO 3 — TAREFAS E ENTREGAS
-- =========================
CREATE TABLE IF NOT EXISTS tarefa (
  id INT AUTO_INCREMENT PRIMARY KEY,
  turma_id INT NOT NULL,
  titulo VARCHAR(150) NOT NULL,
  descricao TEXT NOT NULL,
  data_publicacao DATE NOT NULL,
  data_entrega DATE NOT NULL,
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS tarefa_entrega (
  tarefa_id INT NOT NULL,
  aluno_id INT NOT NULL,
  status ENUM('entregue','nao_entregue','atrasada') NOT NULL,
  data_entrega_efetiva DATE NULL,
  observacao VARCHAR(255) NULL,
  PRIMARY KEY (tarefa_id, aluno_id),
  FOREIGN KEY (tarefa_id) REFERENCES tarefa(id),
  FOREIGN KEY (aluno_id) REFERENCES aluno(id)
) ENGINE=InnoDB;

-- =========================
-- FUNÇÃO 4 — COMUNICADOS
-- =========================
CREATE TABLE IF NOT EXISTS comunicado (
  id INT AUTO_INCREMENT PRIMARY KEY,
  turma_id INT NULL,
  titulo VARCHAR(150) NOT NULL,
  corpo TEXT NOT NULL,
  data_publicacao DATE NOT NULL,
  publico_alvo ENUM('todos','responsaveis','professores','alunos','turma') NOT NULL,
  FOREIGN KEY (turma_id) REFERENCES turma(id)
) ENGINE=InnoDB;
