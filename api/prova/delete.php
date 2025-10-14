<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['id'] ?? '';


    $conn->query("DELETE FROM prova_nota WHERE prova_id = $id");
    $resultado = $conn->query("DELETE FROM prova WHERE id = $id");


    if ($resultado) {
        echo json_encode([
            'success' => true,
            'message' => 'Prova excluída.'
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
