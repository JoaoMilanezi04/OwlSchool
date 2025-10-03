<?php
// api/professor/comunicado.php
require __DIR__ . '/../../db/conexao.php';

/** Criar comunicado */
function createComunicado($titulo, $corpo) {
    global $conn;
    $titulo = $conn->real_escape_string(trim($titulo));
    $corpo  = $conn->real_escape_string(trim($corpo));

    if ($titulo === '' || $corpo === '') return null;

    $sql = "INSERT INTO comunicado (titulo, corpo) VALUES ('$titulo', '$corpo')";
    if ($conn->query($sql)) return $conn->insert_id;
    return null;
}

/** Listar comunicados */
function listComunicadosProfessor() {
    global $conn;
    $sql = "SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC";
    $res = $conn->query($sql);
    if (!$res) return [];
    $out = [];
    while ($row = $res->fetch_assoc()) $out[] = $row;
    return $out;
}

/** Deletar comunicado */
function deleteComunicadoById($id) {
    global $conn;
    $id = (int)$id;
    if ($id <= 0) return false;
    $sql = "DELETE FROM comunicado WHERE id = $id";
    return (bool)$conn->query($sql);
}
