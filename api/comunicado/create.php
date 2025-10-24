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
$corpo  = $_POST['corpo'];


if (empty($titulo) || empty($corpo)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO comunicado (titulo, corpo) VALUES (?, ?)");
$stmt->bind_param("ss", $titulo, $corpo);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Comunicado criado com sucesso.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhum comunicado criado.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar comunicado: ' . $stmt->error
  ]);
}



$stmt->close();
$conn->close();