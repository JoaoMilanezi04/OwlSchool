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


function getResumoFrequencia($alunoUsuarioId) {
    global $conn;
    $sql = "
        SELECT
            COUNT(chamada.id) AS total_dias,
            SUM(CASE WHEN chamada_item.status = 'presente' THEN 1 ELSE 0 END) AS presentes
        FROM chamada
        LEFT JOIN chamada_item
               ON chamada_item.chamada_id = chamada.id
              AND chamada_item.aluno_id = $alunoUsuarioId
    ";
    $resultado = $conn->query($sql);
    $dados = $resultado->fetch_assoc();
    $totalDias = $dados['total_dias'] + 0;
    $presentes = $dados['presentes'] + 0;
    $faltas = $totalDias - $presentes;
    $percentual = $totalDias > 0 ? ($presentes / $totalDias) * 100 : 0;
    return [
        'total_dias' => $totalDias,
        'presentes' => $presentes,
        'faltas' => $faltas,
        'percentual_presenca' => $percentual
    ];
}
