<?php


require __DIR__ . '/../../db/conexao.php';




function deleteTarefa($id) {
    global $conn;
    $sql = "DELETE FROM tarefa WHERE id = $id";
    $conn->query($sql);
}
