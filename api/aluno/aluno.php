<?php

require __DIR__ . '/../../db/conexao.php';

function getAlunoNome($alunoId) {
    global $conn;
    $alunoId = (int)$alunoId;
    $sql = "SELECT u.nome
              FROM aluno a
              JOIN usuario u ON u.id = a.usuario_id
             WHERE a.usuario_id = $alunoId";
    $res = $conn->query($sql);
    if (!$res || $res->num_rows === 0) return null;
    $row = $res->fetch_assoc();
    return $row['nome'];
}

function getNomeResponsavel($alunoId) {
    global $conn;
    $alunoId = (int)$alunoId;
    $sql = "SELECT u.nome
              FROM aluno_responsavel ar
              JOIN responsavel r ON r.usuario_id = ar.responsavel_id
              JOIN usuario u     ON u.id         = r.usuario_id
             WHERE ar.aluno_id = $alunoId
             ORDER BY u.nome
             LIMIT 1";
    $res = $conn->query($sql);
    if (!$res || $res->num_rows === 0) return null;
    $row = $res->fetch_assoc();
    return $row['nome'];
}
