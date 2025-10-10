<?php

require_once __DIR__ . '/../../db/conexao.php';



function criarHorario($diaSemana, $horaInicio, $horaFim, $disciplina) {
    global $conn;

    $sql = "INSERT INTO horarios_aula (dia_semana, inicio, fim, disciplina)
            VALUES ('$diaSemana', '$horaInicio', '$horaFim', '$disciplina')";
    $conn->query($sql);

    return $conn->insert_id;
}
