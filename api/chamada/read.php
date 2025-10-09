<?php
require __DIR__ . '/../../db/conexao.php';

function readChamadas() {
    global $conn;
    $sql = "SELECT id, data FROM chamada ORDER BY data DESC";
    return $conn->query($sql);
}

function readChamadaById($id) {
    global $conn;
    $sql = "SELECT id, data FROM chamada WHERE id = $id";
    return $conn->query($sql);
}