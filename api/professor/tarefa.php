<?php
// api/professor/tarefa.php
require __DIR__ . '/../../db/conexao.php';

/** criar (já tinha) */
function createTarefa($titulo, $descricao, $dataEntrega) {
    global $conn;
    $titulo      = $conn->real_escape_string(trim($titulo));
    $descricao   = $conn->real_escape_string(trim($descricao));
    $dataEntrega = $conn->real_escape_string(trim($dataEntrega));
    if ($titulo === '' || $descricao === '' || $dataEntrega === '') return null;
    $sql = "INSERT INTO tarefa (titulo, descricao, data_entrega)
            VALUES ('$titulo', '$descricao', '$dataEntrega')";
    if ($conn->query($sql)) return $conn->insert_id;
    return null;
}

/** listar */
function listTarefasProfessor() {
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

/** deletar */
function deleteTarefaById($id) {
    global $conn;
    $id = (int)$id;
    if ($id <= 0) return false;
    $sql = "DELETE FROM tarefa WHERE id = $id";
    return (bool)$conn->query($sql);
}
