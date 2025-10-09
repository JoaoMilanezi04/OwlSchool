<?php


require __DIR__ . '/../../db/conexao.php';




function updateTarefa($id, $titulo, $descricao, $dataEntrega) {
    global $conn;
    $sql = "UPDATE tarefa SET titulo = '$titulo', descricao = '$descricao', data_entrega = '$dataEntrega' WHERE id = $id";
    $conn->query($sql);
}