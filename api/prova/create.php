<?php



require __DIR__ . '/../../db/conexao.php';



function createProva($titulo, $data) {
    global $conn;
    $sql = "INSERT INTO prova (titulo, data) VALUES ('$titulo', '$data')";
    $conn->query($sql);
    return $conn->insert_id;
}
