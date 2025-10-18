<?php
require_once __DIR__ . '/../../../db/conexao.php';
session_start();
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'Usuário não logado.']);
        exit;
    }

    $responsavelId = (int) $_SESSION['user_id'];

    $sql = "
        SELECT
            advertencia.id        AS id,
            advertencia.titulo    AS titulo,
            advertencia.descricao AS descricao,
            usuario.nome          AS aluno_nome
        FROM aluno_responsavel
        JOIN aluno_advertencia
          ON aluno_advertencia.aluno_id = aluno_responsavel.aluno_id
        JOIN advertencia
          ON advertencia.id = aluno_advertencia.advertencia_id
        JOIN usuario
          ON usuario.id = aluno_responsavel.aluno_id
        WHERE aluno_responsavel.responsavel_id = $responsavelId
        ORDER BY advertencia.id DESC
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
