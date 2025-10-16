<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $chamadaId = $_POST['chamada_id'] ?? 0;
    $alunoId   = $_POST['aluno_id']   ?? 0;

    $sql = "DELETE FROM chamada_item WHERE chamada_id = $chamadaId AND aluno_id = $alunoId";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Registro de presença removido.'
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
