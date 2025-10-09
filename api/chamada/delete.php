<?php


require __DIR__ . '/../../db/conexao.php';




function deleteChamada($id) {
    global $conn;
    $conn->query("DELETE FROM chamada_item WHERE chamada_id = $id");
    $conn->query("DELETE FROM chamada WHERE id = $id");
}