<?php

require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $titulo       = $_POST['titulo'] ?? '';
    $descricao    = $_POST['descricao'] ?? '';
    $data_entrega = $_POST['data_entrega'] ?? '';


    $sql = "
        INSERT INTO tarefa (titulo, descricao, data_entrega)
        VALUES ('$titulo', '$descricao', '$data_entrega')
    ";




    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Tarefa criada com sucesso.',
            'id' => $conn->insert_id
        ]);



    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar tarefa: ' . $conn->error
        ]);
    }



} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
