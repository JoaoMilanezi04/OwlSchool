<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = $_POST['data'] ?? '';

    $sql = "INSERT INTO chamada (data) VALUES ('$data')";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Chamada criada.',
            'id'      => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
