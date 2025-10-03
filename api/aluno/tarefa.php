<?php
require __DIR__ . '/../../db/conexao.php';

/** Lista todas as tarefas ordenadas por data de entrega */
function listTarefas() {
    global $conn;
    $sql = "SELECT id, titulo, descricao, data_entrega
              FROM tarefa
          ORDER BY data_entrega ASC, id ASC";
    $res = $conn->query($sql);
    if (!$res) return [];
    $out = [];
    while ($row = $res->fetch_assoc()) $out[] = $row;
    return $out;
}
