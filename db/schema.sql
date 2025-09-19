DROP DATABASE IF EXISTS olwschool;
CREATE DATABASE olwschool;
USE olwschool;

CREATE TABLE usuario (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL,
  email VARCHAR(100) NOT NULL UNIQUE,
  senha VARCHAR(60) NOT NULL,
  tipo_usuario ENUM('aluno','professor','responsavel','admin') NOT NULL
);

CREATE TABLE aluno (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  ra VARCHAR(30) NOT NULL UNIQUE,
  CONSTRAINT fk_aluno_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE professor (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  telefone VARCHAR(30) NOT NULL UNIQUE,
  CONSTRAINT fk_prof_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE responsavel (
  id INT PRIMARY KEY AUTO_INCREMENT,
  usuario_id INT NOT NULL,
  telefone VARCHAR(30) NOT NULL UNIQUE,
  CONSTRAINT fk_resp_usuario FOREIGN KEY (usuario_id) REFERENCES usuario(id)
);

CREATE TABLE aluno_responsavel (
  aluno_id INT NOT NULL,
  responsavel_id INT NOT NULL,
  PRIMARY KEY (aluno_id, responsavel_id),
  CONSTRAINT fk_ar_aluno FOREIGN KEY (aluno_id) REFERENCES aluno(id),
  CONSTRAINT fk_ar_resp  FOREIGN KEY (responsavel_id) REFERENCES responsavel(id)
);

CREATE TABLE disciplina (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(100) NOT NULL
);

CREATE TABLE turma (
  id INT PRIMARY KEY AUTO_INCREMENT,
  nome VARCHAR(50) NOT NULL,
  turno VARCHAR(20) NOT NULL,
  serie VARCHAR(20) NOT NULL,
  professor_id INT NOT NULL,
  CONSTRAINT fk_turma_professor FOREIGN KEY (professor_id) REFERENCES professor(id)
);

CREATE TABLE turma_disciplina (
  id INT PRIMARY KEY AUTO_INCREMENT,
  turma_id INT NOT NULL,
  disciplina_id INT NOT NULL,
  UNIQUE (turma_id, disciplina_id),
  CONSTRAINT fk_td_turma      FOREIGN KEY (turma_id) REFERENCES turma(id),
  CONSTRAINT fk_td_disciplina FOREIGN KEY (disciplina_id) REFERENCES disciplina(id)
);

CREATE TABLE matricula (
  id INT PRIMARY KEY AUTO_INCREMENT,
  aluno_id INT NOT NULL,
  turma_id INT NOT NULL,
  UNIQUE (aluno_id, turma_id),
  CONSTRAINT fk_mat_aluno FOREIGN KEY (aluno_id) REFERENCES aluno(id),
  CONSTRAINT fk_mat_turma FOREIGN KEY (turma_id) REFERENCES turma(id)
);

CREATE TABLE avaliacao (
  id INT PRIMARY KEY AUTO_INCREMENT,
  turma_disciplina_id INT NOT NULL,
  titulo VARCHAR(100) NOT NULL,
  bimestre ENUM('1','2','3','4') NOT NULL,
  CONSTRAINT fk_av_td FOREIGN KEY (turma_disciplina_id) REFERENCES turma_disciplina(id)
);

CREATE TABLE nota (
  avaliacao_id INT NOT NULL,
  aluno_id INT NOT NULL,
  nota DECIMAL(5,2),
  PRIMARY KEY (avaliacao_id, aluno_id),
  CONSTRAINT fk_nota_av FOREIGN KEY (avaliacao_id) REFERENCES avaliacao(id),
  CONSTRAINT fk_nota_al FOREIGN KEY (aluno_id) REFERENCES aluno(id)
);

CREATE TABLE tarefa (
  id INT PRIMARY KEY AUTO_INCREMENT,
  turma_disciplina_id INT NOT NULL,
  titulo VARCHAR(120) NOT NULL,
  data_entrega DATE NOT NULL,
  CONSTRAINT fk_tarefa_td FOREIGN KEY (turma_disciplina_id) REFERENCES turma_disciplina(id)
);

CREATE TABLE entrega_tarefa (
  aluno_id INT NOT NULL,
  tarefa_id INT NOT NULL,
  status ENUM('entregue','nao_entregue') NOT NULL DEFAULT 'nao_entregue',
  PRIMARY KEY (aluno_id, tarefa_id),
  CONSTRAINT fk_et_aluno  FOREIGN KEY (aluno_id) REFERENCES aluno(id),
  CONSTRAINT fk_et_tarefa FOREIGN KEY (tarefa_id) REFERENCES tarefa(id)
);

CREATE TABLE comunicado (
  id INT PRIMARY KEY AUTO_INCREMENT,
  titulo VARCHAR(150) NOT NULL,
  corpo TEXT NOT NULL,
  turma_id INT NULL,
  FOREIGN KEY (turma_id) REFERENCES turma(id)
);

CREATE TABLE advertencia (
  id INT PRIMARY KEY AUTO_INCREMENT,
  aluno_id INT NOT NULL,
  motivo TEXT NOT NULL,
  data DATE NOT NULL,
  CONSTRAINT fk_adv_al FOREIGN KEY (aluno_id) REFERENCES aluno(id)
);

CREATE TABLE chamada (
  id INT PRIMARY KEY AUTO_INCREMENT,
  turma_disciplina_id INT NOT NULL,
  data DATE NOT NULL,
  UNIQUE (turma_disciplina_id, data),
  CONSTRAINT fk_chamada_td FOREIGN KEY (turma_disciplina_id) REFERENCES turma_disciplina(id)
);

CREATE TABLE chamada_item (
  chamada_id INT NOT NULL,
  aluno_id INT NOT NULL,
  status ENUM('presente','falta','atraso','justificada') NOT NULL,
  PRIMARY KEY (chamada_id, aluno_id),
  CONSTRAINT fk_chamada_item_chamada FOREIGN KEY (chamada_id) REFERENCES chamada(id) ON DELETE CASCADE,
  CONSTRAINT fk_chamada_item_aluno   FOREIGN KEY (aluno_id)   REFERENCES aluno(id)   ON DELETE CASCADE
);