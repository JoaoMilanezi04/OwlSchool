<?php

require __DIR__ . '/../db/conexao.php';

function getAlunoNome($alunoId) {
    global $conn;
    $sql = "SELECT usuario.nome
              FROM aluno
              JOIN usuario ON usuario.id = aluno.usuario_id
             WHERE aluno.id = $alunoId";
    $row = $conn->query($sql)->fetch_assoc();
    return $row['nome'];
}


function getNomeResponsavel($alunoId) {
    global $conn;
    $sql = "SELECT usuario.nome
              FROM aluno_responsavel
              JOIN responsavel ON responsavel.id = aluno_responsavel.responsavel_id
              JOIN usuario     ON usuario.id     = responsavel.usuario_id
             WHERE aluno_responsavel.aluno_id = $alunoId
             ORDER BY usuario.nome
             LIMIT 1";
    $row = $conn->query($sql)->fetch_assoc();
    return $row['nome'];
}


function getResponsaveisDoAluno($alunoId) {
    global $conn;
    $sql = "SELECT responsavel.id AS responsavel_id,
                   usuario.nome,
                   usuario.email
              FROM aluno_responsavel
              JOIN responsavel ON responsavel.id = aluno_responsavel.responsavel_id
              JOIN usuario     ON usuario.id     = responsavel.usuario_id
             WHERE aluno_responsavel.aluno_id = $alunoId
             ORDER BY usuario.nome";
             
    return $conn->query($sql)->fetch_all(MYSQLI_ASSOC);
}
