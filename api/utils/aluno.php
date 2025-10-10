<?php

require_once __DIR__ . '/../../db/conexao.php';





function getNomeResponsavel($alunoId) {
    global $conn;
    $alunoId = (int)$alunoId;

    $sql = "
        SELECT usuario.nome
          FROM aluno_responsavel
          JOIN responsavel ON responsavel.usuario_id = aluno_responsavel.responsavel_id
          JOIN usuario     ON usuario.id = responsavel.usuario_id
         WHERE aluno_responsavel.aluno_id = $alunoId
         ORDER BY usuario.nome
         LIMIT 1
    ";

    $resultado = $conn->query($sql);
    $linha = $resultado->fetch_assoc();
    return $linha['nome'];
}




function listHorariosPorDia($diaSemana) {
    global $conn;

    $sql = "
        SELECT 
            TIME_FORMAT(inicio, '%H:%i') AS inicio,
            TIME_FORMAT(fim, '%H:%i') AS fim,
            disciplina
        FROM horarios_aula
        WHERE dia_semana = '$diaSemana'
        ORDER BY inicio
    ";

    $resultado = $conn->query($sql);
    $horarios = [];

    while ($linha = $resultado->fetch_assoc()) {
        $horarios[] = $linha;
    }

    return $horarios;
}
