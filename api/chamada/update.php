<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id   = $_POST['id']   ?? '';
    $data = $_POST['data'] ?? '';

    $sql = "UPDATE chamada SET data = '$data' WHERE id = $id";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Chamada atualizada.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao atualizar: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
