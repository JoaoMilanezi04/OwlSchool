<?php

require __DIR__ . '/../../db/conexao.php';




function deleteComunicado($id) {
    global $conn;
    $sql = "DELETE FROM comunicado WHERE id = $id";
    $conn->query($sql);
}



