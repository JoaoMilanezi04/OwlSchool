<?php


require __DIR__ . '/../../db/conexao.php';




function updateChamada($id, $data) {
    global $conn;
    $sql = "UPDATE chamada SET data = '$data' WHERE id = $id";
    $conn->query($sql);
}

