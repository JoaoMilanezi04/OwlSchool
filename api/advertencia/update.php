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


$id        = $_POST['id'];
$titulo    = $_POST['titulo'];
$descricao = $_POST['descricao'];


if (empty($id) || empty($titulo) || empty($descricao)) {
    echo json_encode([
        'success' => false,
        'message' => 'Campos obrigatórios ausentes.'
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE advertencia SET titulo = ?, descricao = ? WHERE id = ?");
$stmt->bind_param("ssi", $titulo, $descricao, $id);


if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            'success' => true,
            'message' => 'Advertência atualizada com sucesso.'
        ]);

    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Nenhum elemento encontrado para atualizar.'
        ]);
    }

} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar advertência: ' . $stmt->error
    ]);
}


$stmt->close();
$conn->close();