<?php
// api/horario/horario.php
require __DIR__ . '/../../db/conexao.php';

/** Lista todos os horários ordenados por início */
function listHorariosAula() {
    global $conn;
    $sql = "SELECT id, inicio, fim, disciplina
              FROM horarios_aula
          ORDER BY inicio ASC, id ASC";
    $res = $conn->query($sql);
    if (!$res) return [];
    $out = [];
    while ($row = $res->fetch_assoc()) $out[] = $row;
    return $out;
}

/** Formata "HH:MM – HH:MM • Disciplina" (string pronta pro HTML) */
function formatHorarioLinha($inicio, $fim, $disciplina) {
    $ini = substr($inicio, 0, 5); // "07:00"
    $fi  = substr($fim,    0, 5); // "07:45"
    return "{$ini} – {$fi} • {$disciplina}";
}
