<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "
        SELECT
            aluno.usuario_id AS aluno_id,
            usuario.nome AS aluno_nome
        FROM aluno
        INNER JOIN usuario
            ON usuario.id = aluno.usuario_id
        ORDER BY usuario.nome ASC
    ";

    $resultado = $conn->query($sql);

    if ($resultado) {
        $alunos = [];
        while ($linha = $resultado->fetch_assoc()) {
            $alunos[] = $linha;
        }

        echo json_encode([
            'success' => true,
            'alunos'  => $alunos
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao listar alunos: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
