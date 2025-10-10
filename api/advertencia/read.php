<?php

require __DIR__ . '/../../db/conexao.php';




function readAdvertencias() {
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






function readAdvertenciasFilho($responsavelId) {
    global $conn;
    $alunoId = getIdFilho($responsavelId);
    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia, advertencia
            WHERE aluno_advertencia.advertencia_id = advertencia.id
              AND aluno_advertencia.aluno_id = $alunoId";
    $resultado = $conn->query($sql);
    $lista = [];
    while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}




function readAdvertenciasAluno($alunoId) {
    global $conn;

    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia
            INNER JOIN advertencia ON aluno_advertencia.advertencia_id = advertencia.id
            WHERE aluno_advertencia.aluno_id = $alunoId";

    $resultado = $conn->query($sql);

    $lista = [];
    while ($linha = $resultado->fetch_assoc()) {
        $lista[] = $linha;
    }

    return $lista;
}