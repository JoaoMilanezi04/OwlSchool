<?php
require __DIR__ . '/../../db/conexao.php';

function updateChamadaItem($chamadaId, $alunoId, $status) {
    global $conn;
    $sql = "
        UPDATE chamada_item
        SET status = '$status'
        WHERE chamada_id = $chamadaId AND aluno_id = $alunoId
    ";
    return $conn->query($sql);
}
