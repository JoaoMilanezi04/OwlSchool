<?php

require_once __DIR__ . '/../../db/conexao.php';



function atualizarHorario($id, $diaSemana, $horaInicio, $horaFim, $disciplina) {
    global $conn;

    $sql = "UPDATE horarios_aula
               SET dia_semana = '$diaSemana',
                   inicio     = '$horaInicio',
                   fim        = '$horaFim',
                   disciplina = '$disciplina'
             WHERE id = $id";
    return $conn->query($sql);
}




