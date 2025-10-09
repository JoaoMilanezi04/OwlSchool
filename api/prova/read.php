<?php



require __DIR__ . '/../../db/conexao.php';




function readProvas() {
    global $conn;
    $sql = "SELECT id, titulo, data FROM prova ORDER BY data DESC, id DESC";
    $resultado = $conn->query($sql);
    $provas = [];
    while ($linha = $resultado->fetch_assoc()) $provas[] = $linha;
    return $provas;
}