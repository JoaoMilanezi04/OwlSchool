<?php


require_once __DIR__ . '/../../db/conexao.php';




function listarHorarios($diaSemana = null) {
    global $conn;

    if ($diaSemana) {
        $sql = "SELECT id, dia_semana, inicio, fim, disciplina
                  FROM horarios_aula
                 WHERE dia_semana = '$diaSemana'
              ORDER BY FIELD(dia_semana,'segunda','terca','quarta','quinta','sexta'), inicio, fim, id";
        $resultado = $conn->query($sql);
    } else {
        $sql = "SELECT id, dia_semana, inicio, fim, disciplina
                  FROM horarios_aula
              ORDER BY FIELD(dia_semana,'segunda','terca','quarta','quinta','sexta'), inicio, fim, id";
        $resultado = $conn->query($sql);
    }

    $lista = [];
    if ($resultado) while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}









function buscarHorarioPorId($id) {
    global $conn;

    $sql = "SELECT id, dia_semana, inicio, fim, disciplina
              FROM horarios_aula
             WHERE id = $id";
    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }
    return null;
}









function criarHorario($diaSemana, $horaInicio, $horaFim, $disciplina) {
    global $conn;

    $sql = "INSERT INTO horarios_aula (dia_semana, inicio, fim, disciplina)
            VALUES ('$diaSemana', '$horaInicio', '$horaFim', '$disciplina')";
    $conn->query($sql);

    return $conn->insert_id;
}









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









function deletarHorario($id) {
    global $conn;

    $sql = "DELETE FROM horarios_aula WHERE id = $id";
    return $conn->query($sql);
}










function substituirHorariosDoDia($diaSemana, $itens) {
    global $conn;

    $sqlApagar = "DELETE FROM horarios_aula WHERE dia_semana = '$diaSemana'";
    $conn->query($sqlApagar);

    foreach ($itens as $item) {
        $inicio     = $item['inicio'];
        $fim        = $item['fim'];
        $disciplina = $item['disciplina'];

        $sqlInserir = "INSERT INTO horarios_aula (dia_semana, inicio, fim, disciplina)
                       VALUES ('$diaSemana', '$inicio', '$fim', '$disciplina')";
        $conn->query($sqlInserir);
    }

    return true;
}
