<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $chamadaId = (int)($_POST['chamada_id'] ?? 0);

    if ($chamadaId <= 0) {
        echo json_encode([
            'success' => false,
            'message' => 'ID da chamada não informado.'
        ]);
        exit;
    }

    $sql = "
        SELECT
            ci.chamada_id,
            a.usuario_id AS aluno_id,
            u.nome AS aluno_nome,
            ci.status
        FROM aluno a
        JOIN usuario u ON u.id = a.usuario_id
        LEFT JOIN chamada_item ci
               ON ci.aluno_id = a.usuario_id
              AND ci.chamada_id = $chamadaId
        ORDER BY u.nome
    ";

    $resultado = $conn->query($sql);

    if (!$resultado) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao buscar presenças: ' . $conn->error
        ]);
        exit;
    }

    $itens = [];
    while ($linha = $resultado->fetch_assoc()) {
        $itens[] = $linha;
    }

    echo json_encode([
        'success' => true,
        'itens' => $itens
    ]);

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
