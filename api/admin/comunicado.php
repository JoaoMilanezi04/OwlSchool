<?php

require __DIR__ . '/../../db/conexao.php';







function createComunicado($titulo, $corpo) {
    global $conn;
    $sql = "INSERT INTO comunicado (titulo, corpo) VALUES ('$titulo', '$corpo')";
    $conn->query($sql);
    return $conn->insert_id;
}







function listComunicadosProfessor() {
    global $conn;
    $sql = "SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC";
    $resultado = $conn->query($sql);
    $comunicados = [];
    while ($linha = $resultado->fetch_assoc()) $comunicados[] = $linha;
    return $comunicados;
}







function deleteComunicadoById($id) {
    global $conn;
    $sql = "DELETE FROM comunicado WHERE id = $id";
    $conn->query($sql);
}
