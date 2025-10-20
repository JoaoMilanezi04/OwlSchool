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


$stmt1 = $conn->prepare("DELETE FROM aluno_advertencia WHERE advertencia_id = ?");
$stmt1->bind_param("i", $id);


$stmt1->execute();
$stmt1->close();


$stmt2 = $conn->prepare("DELETE FROM advertencia WHERE id = ?");
$stmt2->bind_param("i", $id);


if ($stmt2->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Advertência excluída com sucesso.'
  ]);
  
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir advertência.'
  ]);
}


$stmt2->close();
$conn->close();
