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


$id = $_POST['id'];


$stmt = $conn->prepare("DELETE FROM tarefa WHERE id = ?");
$stmt->bind_param("i", $id);


if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Tarefa excluída com sucesso.'
  ]);
  
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir tarefa.'
  ]);
}


$stmt->close();
$conn->close();