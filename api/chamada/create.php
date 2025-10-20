<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Método inválido.'
  ]);
  exit;
}


$data = $_POST['data'] ?? '';


if (empty($data)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campo "data" é obrigatório.'
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO chamada (data) VALUES (?)");
$stmt->bind_param("s", $data);


if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Chamada criada com sucesso.',
    'id'      => $conn->insert_id
  ]);

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar chamada: ' . $stmt->error
  ]);
}


$stmt->close();
$conn->close();
