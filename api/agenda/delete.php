<?php

require_once __DIR__ . '/../../db/conexao.php';



function deletarHorario($id) {
    global $conn;

    $sql = "DELETE FROM horarios_aula WHERE id = $id";
    return $conn->query($sql);
}
