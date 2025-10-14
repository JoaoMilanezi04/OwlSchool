<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $sql = "SELECT id, titulo, data FROM prova ORDER BY data DESC, id DESC";
    $resultado = $conn->query($sql);


    if ($resultado) {

        $provas = [];

        while ($linha = $resultado->fetch_assoc()) $provas[] = $linha;


        echo json_encode([
            'success' => true,
            'provas'  => $provas
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
