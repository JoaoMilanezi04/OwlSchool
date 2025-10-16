<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $chamadaId = $_POST['chamada_id'] ?? 0;
    $alunoId   = $_POST['aluno_id']   ?? 0;
    $status    = $_POST['status']     ?? '';

    $sql = "
        INSERT INTO chamada_item (chamada_id, aluno_id, status)
        VALUES ($chamadaId, $alunoId, '$status')
        ON DUPLICATE KEY UPDATE status = '$status'
    ";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Status de presença salvo.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao salvar: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
