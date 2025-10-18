<?php
require_once __DIR__ . '/../../../db/conexao.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado.']);
        exit;
    }

    $usuarioId = (int) $_SESSION['user_id'];

    $sql = "
        SELECT
            p.id         AS prova_id,
            p.titulo     AS titulo,
            p.data       AS data,
            pn.nota      AS nota
        FROM prova_nota AS pn
        JOIN prova AS p
          ON p.id = pn.prova_id
        WHERE pn.aluno_id = $usuarioId
        ORDER BY p.data DESC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $notas = [];
        while ($linha = $resultado->fetch_assoc()) {
            $notas[] = $linha;
        }

        echo json_encode([
            'success' => true,
            'notas' => $notas
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
