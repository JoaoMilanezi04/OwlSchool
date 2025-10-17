<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id = $_POST['id'] ?? '';

    if (empty($id)) {
        echo json_encode([
            'success' => false,
            'message' => 'ID da advertência não informado.'
        ]);
        exit;
    }

    // Excluir vínculos com alunos primeiro
    $sql1 = "DELETE FROM aluno_advertencia WHERE advertencia_id = $id";
    $conn->query($sql1);

    // Excluir advertência principal
    $sql2 = "DELETE FROM advertencia WHERE id = $id";

    if ($conn->query($sql2)) {
        echo json_encode([
            'success' => true,
            'message' => 'Advertência excluída com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao excluir advertência: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
