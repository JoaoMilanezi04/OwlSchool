<?php
require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'] ?? '';
    $corpo  = $_POST['corpo'] ?? '';


    $sql = "
        INSERT INTO comunicado (titulo, corpo)
        VALUES ('$titulo', '$corpo')
    ";


    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Comunicado criado com sucesso.',
            'id' => $conn->insert_id
        ]);


    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar comunicado: ' . $conn->error
        ]);
    }


} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
?>
