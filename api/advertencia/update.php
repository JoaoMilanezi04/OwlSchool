<?php

require __DIR__ . '/../../db/conexao.php';




function updateAdvertencia($id, $titulo, $descricao) {
    global $conn;
    $sql = "
        UPDATE advertencia
           SET titulo = '$titulo',
               descricao = '$descricao'
         WHERE id = $id
    ";
    $conn->query($sql);
}
