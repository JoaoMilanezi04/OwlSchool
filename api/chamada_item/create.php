<?php
require __DIR__ . '/../../db/conexao.php';

function createChamadaItem($chamadaId, $alunoId, $status) {
    global $conn;
    $sql = "
        INSERT INTO chamada_item (chamada_id, aluno_id, status)
        VALUES ($chamadaId, $alunoId, '$status')
        ON DUPLICATE KEY UPDATE status = '$status'
    ";
    return $conn->query($sql);
}

function saveChamadaEmMassa($chamadaId, $itens) {
    foreach ($itens as $alunoId => $status) {
        createChamadaItem($chamadaId, $alunoId, $status);
    }
}
