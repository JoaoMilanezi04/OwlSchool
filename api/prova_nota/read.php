<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $prova_id = $_POST['prova_id'] ?? '';

    if ($prova_id === '') {
        echo json_encode([
            'success' => false,
            'message' => 'O campo prova_id é obrigatório.'
        ]);
        exit;
    }

    $sql = "
        SELECT 
            $prova_id AS prova_id,
            aluno.usuario_id AS aluno_id,
            usuario.nome AS aluno_nome,
            prova_nota.nota
        FROM aluno
        JOIN usuario ON usuario.id = aluno.usuario_id
        LEFT JOIN prova_nota 
               ON prova_nota.aluno_id = aluno.usuario_id 
              AND prova_nota.prova_id = $prova_id
        ORDER BY usuario.nome
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
            'message' => 'Erro ao listar: ' . $conn->error
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
?>
