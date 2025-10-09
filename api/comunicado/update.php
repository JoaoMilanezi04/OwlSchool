<?php

require __DIR__ . '/../../db/conexao.php';




function updateComunicado($id, $titulo, $corpo) {
    global $conn;
    $sql = "
        UPDATE comunicado
           SET titulo = '$titulo',
               corpo  = '$corpo'
         WHERE id = $id
    ";
    $conn->query($sql);
}
