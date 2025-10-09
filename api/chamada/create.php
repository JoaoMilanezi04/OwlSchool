<?php


require __DIR__ . '/../../db/conexao.php';




function createChamada($data) {
    global $conn;
    $sql = "INSERT INTO chamada (data) VALUES ('$data')";
    $conn->query($sql);
    return $conn->insert_id;
}