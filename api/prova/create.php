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


$titulo = $_POST['titulo'];
$data   = $_POST['data'];


if (empty($titulo) || empty($data)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}



$stmt = $conn->prepare("INSERT INTO prova (titulo, data) VALUES (?, ?)");
$stmt->bind_param("ss", $titulo, $data);



if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Prova criada com sucesso.',
  ]);

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar prova: ' . $stmt->error
  ]);
}


$stmt->close();
$conn->close();