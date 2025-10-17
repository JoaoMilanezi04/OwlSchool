<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $chamadaId = $_POST['chamada_id'] ?? 0;
    $alunoId   = $_POST['aluno_id']   ?? 0;
    $status    = $_POST['status']     ?? '';

    $sql = "
        UPDATE chamada_item
        SET status = '$status'
        WHERE chamada_id = $chamadaId AND aluno_id = $alunoId
    ";

if ($conn->query($sql)) {
    if ($conn->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Status de presença atualizado com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nenhum registro encontrado para atualizar.'
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar presença: ' . $conn->error
    ]);
}
}
