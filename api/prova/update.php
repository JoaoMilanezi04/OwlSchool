<?php

require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        "success" => false,
        "message" => "Método inválido."
    ]);
    exit;
}


$id     = $_POST['id'];
$titulo = $_POST['titulo'];
$data   = $_POST['data'];


if (empty($id) || empty($titulo) || empty($data)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE prova SET titulo = ?, data = ? WHERE id = ?");
$stmt->bind_param("ssi", $titulo, $data, $id);


if ($stmt->execute()) {
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Prova atualizada com sucesso."
        ]);

    } else {
        echo json_encode([
            "success" => false,
            "message" => "Nenhum elemento encontrado para atualizar."
        ]);
    }

} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar prova: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();