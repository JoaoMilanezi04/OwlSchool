<?php


require __DIR__ . '/../../db/conexao.php';




function deleteNotaAluno($provaId, $alunoId) {
    global $conn;
    $sql = "DELETE FROM prova_nota
            WHERE prova_id = $provaId AND aluno_id = $alunoId";
    $conn->query($sql);
}


function deleteNotasByProva($provaId) {
    global $conn;
    $sql = "DELETE FROM prova_nota WHERE prova_id = $provaId";
    $conn->query($sql);
}