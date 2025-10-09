<?php

require __DIR__ . '/../../db/conexao.php';



function createAdvertencia($titulo, $descricao) {
    global $conn;
    $sql = "INSERT INTO advertencia (titulo, descricao) VALUES ('$titulo', '$descricao')";
    $conn->query($sql);
    return $conn->insert_id;
}





function vincularAlunoAdvertencia($advertenciaId, $alunoUsuarioId) {
    global $conn;
    $sql = "
        INSERT INTO aluno_advertencia (advertencia_id, aluno_id)
        VALUES ($advertenciaId, $alunoUsuarioId)
        ON DUPLICATE KEY UPDATE aluno_id = aluno_id
    ";
    $conn->query($sql);
}
