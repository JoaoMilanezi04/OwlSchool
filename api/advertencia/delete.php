<?php

require __DIR__ . '/../../db/conexao.php';



function deleteAdvertencia($id) {
    global $conn;

    $sql = "DELETE FROM aluno_advertencia WHERE advertencia_id = $id";
    $conn->query($sql);

    $sql = "DELETE FROM advertencia WHERE id = $id";
    $conn->query($sql);
}