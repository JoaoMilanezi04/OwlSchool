<?php


require __DIR__ . '/../../db/conexao.php';




function updateNota($provaId, $alunoId, $nota) {
    global $conn;
    $sql = "
        UPDATE prova_nota
           SET nota = '$nota'
         WHERE prova_id = $provaId
           AND aluno_id = $alunoId
    ";
    $conn->query($sql);
}

