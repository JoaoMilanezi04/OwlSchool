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


$stmt = $conn->prepare("DELETE FROM prova_nota WHERE prova_id = ? AND aluno_id = ?");
$stmt->bind_param("ii", $prova_id, $aluno_id);


if ($stmt->execute()) {
  echo json_encode([
    'success' => true,
    'message' => 'Nota excluída.'
  ]);
  
} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir nota.'
  ]);
}


$stmt->close();
$conn->close();