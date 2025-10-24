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


$prova_id = $_POST['prova_id'];
$aluno_id = $_POST['aluno_id'];
$nota     = $_POST['nota'];


if (empty($prova_id) || empty($aluno_id) || empty($nota)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO prova_nota (prova_id, aluno_id, nota) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE nota = VALUES(nota)");
$stmt->bind_param("iid", $prova_id, $aluno_id, $nota);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Nota criada ou atualizada com sucesso.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhuma nota criada ou atualizada.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar ou atualizar nota: ' . $stmt->error
  ]);
}



$stmt->close();
$conn->close();
