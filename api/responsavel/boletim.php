<?php

require_once __DIR__ . '/../../db/conexao.php';




function listProvasENotasDoAluno($alunoId) {
    global $conn;
    $alunoId = (int)$alunoId;

    $sql = "
        SELECT 
            prova.id AS prova_id,
            prova.titulo AS titulo,
            prova.data AS data,
            prova_nota.nota AS nota
        FROM prova
        LEFT JOIN prova_nota 
          ON prova_nota.prova_id = prova.id 
         AND prova_nota.aluno_id = $alunoId
        ORDER BY prova.data DESC, prova.id DESC
    ";

    $resultado = $conn->query($sql);
    $lista = [];

    while ($linha = $resultado->fetch_assoc()) {
        $lista[] = $linha;
    }

    return $lista;
}








function mediaNotasDoAluno($alunoId) {
    global $conn;
    $alunoId = (int)$alunoId;

    $sql = "SELECT AVG(nota) AS media FROM prova_nota WHERE aluno_id = $alunoId";
    $resultado = $conn->query($sql);
    $linha = $resultado->fetch_assoc();

    return $linha['media'];
}
