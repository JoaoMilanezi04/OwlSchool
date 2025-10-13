<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = $_POST['id']     ?? '';
    $titulo = $_POST['titulo'] ?? '';
    $corpo  = $_POST['corpo']  ?? '';

    if ($id === '' || $titulo === '' || $corpo === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Preencha todos os campos.'
        ]);
        exit;
    }

    $sql = "
        UPDATE comunicado
           SET titulo = '$titulo',
               corpo  = '$corpo'
         WHERE id = $id
    ";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Comunicado atualizado com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao atualizar comunicado: ' . $conn->error
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
?>
