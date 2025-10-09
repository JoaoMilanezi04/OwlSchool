<?php



require __DIR__ . '/../../db/conexao.php';




function deleteProvaById($id) {
    global $conn;
    $sql1 = "DELETE FROM prova_nota WHERE prova_id = $id";
    $conn->query($sql1);
    $sql2 = "DELETE FROM prova WHERE id = $id";
    $conn->query($sql2);
}
