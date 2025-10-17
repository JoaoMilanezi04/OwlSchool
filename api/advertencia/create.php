<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';
    $alunoUsuarioId = $_POST['aluno_id'] ?? '';

    if (empty($titulo) || empty($descricao) || empty($alunoUsuarioId)) {
        echo json_encode([
            'success' => false,
            'message' => 'Campos obrigatórios ausentes.'
        ]);
        exit;
    }

    // Criar advertência
    $sqlAdvertencia = "INSERT INTO advertencia (titulo, descricao) VALUES ('$titulo', '$descricao')";

    if ($conn->query($sqlAdvertencia)) {
        $advertenciaId = $conn->insert_id;

        // Vincular aluno
        $sqlVinculo = "
            INSERT INTO aluno_advertencia (advertencia_id, aluno_id)
            VALUES ($advertenciaId, $alunoUsuarioId)
            ON DUPLICATE KEY UPDATE aluno_id = aluno_id
        ";

        if ($conn->query($sqlVinculo)) {
            echo json_encode([
                'success' => true,
                'message' => 'Advertência criada e vinculada com sucesso.',
                'id'      => $advertenciaId
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Erro ao vincular aluno: ' . $conn->error
            ]);
        }

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar advertência: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
