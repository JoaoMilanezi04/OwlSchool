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


$stmt = $conn->prepare("DELETE FROM prova WHERE id = ?");
$stmt->bind_param("i", $id);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Prova excluída com sucesso.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhuma prova encontrada para excluir.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir prova: ' . $stmt->error
  ]);
}



$stmt->close();
$conn->close();
