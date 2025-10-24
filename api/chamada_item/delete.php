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


$stmt = $conn->prepare("DELETE FROM chamada_item WHERE chamada_id = ? AND aluno_id = ?");
$stmt->bind_param("ii", $chamadaId, $alunoId);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Registro de presença removido.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhum registro de presença encontrado para excluir.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao excluir registro de presença: ' . $stmt->error
  ]);
}



$stmt->close();
$conn->close();