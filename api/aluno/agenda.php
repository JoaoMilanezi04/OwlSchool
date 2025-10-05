<?php

require_once __DIR__ . '/../../db/conexao.php';




function listHorariosSemana() {
    global $conn;

    $sql = "
        SELECT 
            dia_semana,
            TIME_FORMAT(inicio, '%H:%i') AS inicio,
            TIME_FORMAT(fim, '%H:%i') AS fim,
            disciplina
        FROM horarios_aula
        ORDER BY FIELD(dia_semana, 'segunda', 'terca', 'quarta', 'quinta', 'sexta'), inicio
    ";

    $resultado = $conn->query($sql);

    $horarios = [
        'segunda' => [],
        'terca'   => [],
        'quarta'  => [],
        'quinta'  => [],
        'sexta'   => []
    ];

    while ($linha = $resultado->fetch_assoc()) {
        $horarios[$linha['dia_semana']][] = $linha;
    }

    return $horarios;
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
