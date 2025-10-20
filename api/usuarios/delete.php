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


$stmt1 = $conn->prepare("DELETE FROM aluno WHERE usuario_id = ?");
$stmt1->bind_param("i", $id);
$stmt1->execute();
$stmt1->close();


$stmt2 = $conn->prepare("DELETE FROM professor WHERE usuario_id = ?");
$stmt2->bind_param("i", $id);
$stmt2->execute();
$stmt2->close();


$stmt3 = $conn->prepare("DELETE FROM responsavel WHERE usuario_id = ?");
$stmt3->bind_param("i", $id);
$stmt3->execute();
$stmt3->close();


$stmt4 = $conn->prepare("DELETE FROM usuario WHERE id = ?");
$stmt4->bind_param("i", $id);


if ($stmt4->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Usuário excluído com sucesso.'
  ]);
  
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir usuário.'
  ]);
}


$stmt4->close();
$conn->close();
