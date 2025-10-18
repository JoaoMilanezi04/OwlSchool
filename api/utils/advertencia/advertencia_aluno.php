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
            aadv.advertencia_id AS id,
            adv.titulo          AS titulo,
            adv.descricao       AS descricao,
            u.nome              AS aluno_nome
        FROM aluno AS a
        JOIN aluno_advertencia AS aadv
          ON aadv.aluno_id = a.usuario_id
        JOIN advertencia AS adv
          ON adv.id = aadv.advertencia_id
        JOIN usuario AS u
          ON u.id = a.usuario_id
        WHERE a.usuario_id = $usuarioId
        ORDER BY adv.id DESC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $advertencias = [];
        while ($linha = $resultado->fetch_assoc()) {
            $advertencias[] = $linha;
        }

        echo json_encode([
            'success' => true,
            'advertencias' => $advertencias
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
