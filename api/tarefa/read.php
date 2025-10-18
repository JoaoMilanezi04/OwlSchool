<?php
require_once __DIR__ . '/../../db/conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "SELECT id, titulo, descricao, data_entrega FROM tarefa ORDER BY id DESC";
    $resultado = $conn->query($sql);

    if ($resultado) {
        $tarefas = [];
        while ($linha = $resultado->fetch_assoc()) {
            $tarefas[] = $linha;
        }

        echo json_encode([
            'success' => true,
            'tarefas' => $tarefas,
            'tipo_usuario' => $_SESSION['tipo_usuario'] ?? null
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
