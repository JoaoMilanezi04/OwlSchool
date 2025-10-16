<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sql = "SELECT id, data FROM chamada ORDER BY data DESC, id DESC";
    $resultado = $conn->query($sql);

    if ($resultado) {

        $chamadas = [];

        while ($linha = $resultado->fetch_assoc()) $chamadas[] = $linha;

        echo json_encode([
            'success'  => true,
            'chamadas' => $chamadas
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
