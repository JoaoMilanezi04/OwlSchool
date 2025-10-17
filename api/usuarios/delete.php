<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id = $_POST['id'] ?? 0;


    $conn->query("DELETE FROM aluno WHERE usuario_id = $id");
    $conn->query("DELETE FROM professor WHERE usuario_id = $id");
    $conn->query("DELETE FROM responsavel WHERE usuario_id = $id");
    $sql = "DELETE FROM usuario WHERE id = $id";


    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Usuário excluído com sucesso.'
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
