<?php
require __DIR__ . '/../../db/conexao.php';



function deleteChamadaItem($chamadaId, $alunoId) {
    global $conn;
    $sql = "DELETE FROM chamada_item WHERE chamada_id = $chamadaId AND aluno_id = $alunoId";
    return $conn->query($sql);
}
