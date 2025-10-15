<?php

require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $sql = "SELECT id, titulo, descricao, data_entrega FROM tarefa ORDER BY id DESC";
    $resultado = $conn->query($sql);


    $tarefas = [];
    if ($resultado) {

        while ($linha = $resultado->fetch_assoc()) {
            $tarefas[] = $linha;
        }



        echo json_encode([
            'success' => true,
            'tarefas' => $tarefas
        ]);



    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao listar: ' . $conn->error
        ]);
    }



} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
