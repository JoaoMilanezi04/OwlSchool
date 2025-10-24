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


$chamadaId = $_POST['chamada_id'];
$alunoId   = $_POST['aluno_id'];
$status    = $_POST['status'];


if (empty($chamadaId) || empty($alunoId) || empty($status)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO chamada_item (chamada_id, aluno_id, status) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE status = VALUES(status)");
$stmt->bind_param("iis", $chamadaId, $alunoId, $status);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Status de presença salvo.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhum status de presença criado.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao salvar status de presença: ' . $stmt->error
  ]);
}




$stmt->close();
$conn->close();
