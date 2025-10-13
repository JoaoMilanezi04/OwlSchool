<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id = $_POST['id'] ?? '';

  // primeiro remove notas vinculadas (simples, sem FK em cascata)
  $conn->query("DELETE FROM prova_nota WHERE prova_id = $id");
  $ok = $conn->query("DELETE FROM prova WHERE id = $id");

  if ($ok) echo json_encode(['success' => true, 'message' => 'Prova excluída.']);
  else echo json_encode(['success' => false, 'message' => 'Erro ao excluir: ' . $conn->error]);
} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
