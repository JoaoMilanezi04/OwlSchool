<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id     = $_POST['id'] ?? '';
  $titulo = $_POST['titulo'] ?? '';
  $data   = $_POST['data'] ?? '';

  $sql = "UPDATE prova SET titulo='$titulo', data='$data' WHERE id=$id";
  if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Prova atualizada.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $conn->error]);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
