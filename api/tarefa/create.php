<?php


require __DIR__ . '/../../db/conexao.php';




function createTarefa($titulo, $descricao, $dataEntrega) {
    global $conn;
    $sql = "INSERT INTO tarefa (titulo, descricao, data_entrega) VALUES ('$titulo', '$descricao', '$dataEntrega')";
    $conn->query($sql);
    return $conn->insert_id;
}
