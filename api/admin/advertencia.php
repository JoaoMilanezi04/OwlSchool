<?php

require __DIR__ . '/../../db/conexao.php';





function createAdvertencia($titulo, $descricao) {
    global $conn;
    $sql = "INSERT INTO advertencia (titulo, descricao) VALUES ('$titulo', '$descricao')";
    $conn->query($sql);
    return $conn->insert_id;
}





function deleteAdvertenciaById($id) {
    global $conn;

    $sql = "DELETE FROM aluno_advertencia WHERE advertencia_id = $id";
    $conn->query($sql);

    $sql = "DELETE FROM advertencia WHERE id = $id";
    $conn->query($sql);
}





function updateAdvertencia($id, $titulo, $descricao) {
    global $conn;
    $sql = "
        UPDATE advertencia
           SET titulo = '$titulo',
               descricao = '$descricao'
         WHERE id = $id
    ";
    $conn->query($sql);
}





function listAlunosComAdvertencia() {
    global $conn;
    $sql = "
        SELECT
            advertencia.id,
            advertencia.titulo,
            advertencia.descricao,
            usuario.nome AS aluno_nome
        FROM advertencia
        LEFT JOIN aluno_advertencia
            ON aluno_advertencia.advertencia_id = advertencia.id
        LEFT JOIN usuario
            ON usuario.id = aluno_advertencia.aluno_id
        ORDER BY advertencia.id DESC
    ";
    $resultado = $conn->query($sql);

    $lista = [];
    while ($linha = $resultado->fetch_assoc()) {
        $lista[] = $linha;
    }
    return $lista;
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







