<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $id        = $_POST['id'] ?? '';
    $titulo    = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    if (empty($id) || empty($titulo) || empty($descricao)) {
        echo json_encode([
            'success' => false,
            'message' => 'Campos obrigatórios ausentes.'
        ]);
        exit;
    }

    $sql = "
        UPDATE advertencia
           SET titulo = '$titulo',
               descricao = '$descricao'
         WHERE id = $id
    ";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Advertência atualizada com sucesso.'
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
