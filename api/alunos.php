<?php
// api/alunos.php — DEMO ultra simples (legível, sem abreviações)
require_once __DIR__ . '/../db/conexao.php'; // $conn

// Nome do aluno a partir do id da tabela "aluno"
function getAlunoNome($alunoId) {
    global $conn;

    $sql = "
      SELECT usuario.nome
        FROM aluno
        JOIN usuario ON usuario.id = aluno.usuario_id
       WHERE aluno.id = $alunoId
    ";
    $result = $conn->query($sql);
    $row    = $result ? $result->fetch_assoc() : null;

    return $row ? $row['nome'] : null;
}

// Nome de um responsável (primeiro por ordem alfabética)
function getNomeResponsavel($alunoId) {
    global $conn;

    $sql = "
      SELECT usuario.nome AS responsavel_nome
        FROM aluno_responsavel
        JOIN responsavel ON responsavel.id = aluno_responsavel.responsavel_id
        JOIN usuario     ON usuario.id     = responsavel.usuario_id
       WHERE aluno_responsavel.aluno_id = $alunoId
       ORDER BY usuario.nome
    ";
    $result = $conn->query($sql);
    $row    = $result ? $result->fetch_assoc() : null;

    return $row ? $row['responsavel_nome'] : null;
}

// Lista completa de responsáveis (id, nome, email)
function getResponsaveisDoAluno($alunoId) {
    global $conn;

    $sql = "
      SELECT responsavel.id AS responsavel_id,
             usuario.nome,
             usuario.email
        FROM aluno_responsavel
        JOIN responsavel ON responsavel.id = aluno_responsavel.responsavel_id
        JOIN usuario     ON usuario.id     = responsavel.usuario_id
       WHERE aluno_responsavel.aluno_id = $alunoId
       ORDER BY usuario.nome
    ";
    $result = $conn->query($sql);

    return $result ? $result->fetch_all(MYSQLI_ASSOC) : [];
}
