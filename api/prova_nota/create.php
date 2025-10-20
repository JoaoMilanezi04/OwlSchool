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


$prova_id = $_POST['prova_id'] ?? '';
$aluno_id = $_POST['aluno_id'] ?? '';
$nota     = $_POST['nota']     ?? '';


if ($prova_id === '' || $aluno_id === '' || $nota === '') {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios não informados.'
  ]);
  exit;
}


$stmt = $conn->prepare("
INSERT INTO prova_nota (prova_id, aluno_id, nota)
  VALUES (?, ?, ?)
  ON DUPLICATE KEY UPDATE nota = VALUES(nota)
");
$stmt->bind_param("iid", $prova_id, $aluno_id, $nota);


if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Nota criada ou atualizada com sucesso.'
  ]);

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar nota: ' . $stmt->error
  ]);
}


$stmt->close();
$conn->close();
