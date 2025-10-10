<?php
require __DIR__ . '/../../db/conexao.php';

function createNota($provaId, $alunoId, $nota) {
    global $conn;
    $sql = "
        INSERT INTO prova_nota (prova_id, aluno_id, nota)
        VALUES ($provaId, $alunoId, '$nota')
        ON DUPLICATE KEY UPDATE nota = VALUES(nota)
    ";
    $conn->query($sql);
}

function saveNotasEmMassa($provaId, $mapNotas /* [alunoId => nota] */) {
    foreach ($mapNotas as $alunoId => $nota) {
        if ($nota === '' || $nota === null) continue; // ignora vazios
        createNota($provaId, $alunoId, $nota);
    }
}
