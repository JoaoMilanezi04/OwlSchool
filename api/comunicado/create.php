<?php

require __DIR__ . '/../../db/conexao.php';




function createComunicado($titulo, $corpo) {
    global $conn;
    $sql = "INSERT INTO comunicado (titulo, corpo) VALUES ('$titulo', '$corpo')";
    $conn->query($sql);
    return $conn->insert_id;
}
