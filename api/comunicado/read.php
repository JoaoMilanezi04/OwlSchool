<?php

require __DIR__ . '/../../db/conexao.php';




function readComunicado() {
    global $conn;
    $sql = "SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC";
    $resultado = $conn->query($sql);
    $comunicados = [];
    while ($linha = $resultado->fetch_assoc()) $comunicados[] = $linha;
    return $comunicados;
}