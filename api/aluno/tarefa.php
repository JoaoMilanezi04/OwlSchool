<?php

require_once __DIR__ . '/../../db/conexao.php';




function listTarefas() {
    global $conn;

    $sql = "
        SELECT 
            id,
            titulo,
            descricao,
            data_entrega
        FROM tarefa
        ORDER BY data_entrega ASC, id ASC
    ";

    $resultado = $conn->query($sql);
    $tarefas = [];

    while ($linha = $resultado->fetch_assoc()) {
        $tarefas[] = $linha;
    }

    return $tarefas;
}
