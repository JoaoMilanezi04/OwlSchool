<?php


require __DIR__ . '/../../db/conexao.php';





function readTarefa() {
    global $conn;
    $sql = "SELECT id, titulo, descricao, data_entrega FROM tarefa";
    $resultado = $conn->query($sql);
    $tarefas = [];
    while ($linha = $resultado->fetch_assoc()) $tarefas[] = $linha;
    return $tarefas;
}