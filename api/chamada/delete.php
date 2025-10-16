<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? 0;

    $sql = "DELETE FROM chamada WHERE id = $id";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Chamada excluída com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao excluir: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
