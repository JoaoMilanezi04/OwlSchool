<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prova_id = $_POST['prova_id'] ?? '';
    $aluno_id = $_POST['aluno_id'] ?? '';
    $nota     = $_POST['nota'] ?? '';

    if ($prova_id === '' || $aluno_id === '' || $nota === '') {
        echo json_encode([
            'success' => false,
            'message' => 'Campos obrigatórios não informados.'
        ]);
        exit;
    }

    $sql = "
        INSERT INTO prova_nota (prova_id, aluno_id, nota)
        VALUES ($prova_id, $aluno_id, '$nota')
        ON DUPLICATE KEY UPDATE nota = VALUES(nota)
    ";

    if ($conn->query($sql)) {
        echo json_encode([
            'success' => true,
            'message' => 'Nota criada ou atualizada com sucesso.'
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar nota: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
?>
