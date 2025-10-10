<?php
require __DIR__ . '/../../db/conexao.php';

function readChamadas() {
    global $conn;
    $sql = "SELECT id, data FROM chamada ORDER BY data DESC";
    return $conn->query($sql);
}

