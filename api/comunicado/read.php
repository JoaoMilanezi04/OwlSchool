<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sql = "SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC";
    $resultado = $conn->query($sql);

    if ($resultado) {
        $comunicados = [];
        while ($linha = $resultado->fetch_assoc()) {
            $comunicados[] = $linha;
        }

        echo json_encode([
            'success' => true,
            'comunicados' => $comunicados
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
