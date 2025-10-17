<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $prova_id = (int)($_POST['prova_id'] ?? 0);
  $aluno_id = (int)($_POST['aluno_id'] ?? 0);
  $nota     = $_POST['nota'] ?? '';

  if ($prova_id <= 0 || $aluno_id <= 0 || $nota === '') {
    echo json_encode(['success' => false, 'message' => 'Dados inválidos.']);
    exit;
  }

  // UPDATE apenas (não cria registro novo)
  $sql = "UPDATE prova_nota 
          SET nota = $nota 
          WHERE prova_id = $prova_id 
            AND aluno_id = $aluno_id";

  if ($conn->query($sql)) {
    if ($conn->affected_rows > 0) {
      echo json_encode(['success' => true, 'message' => 'Nota atualizada com sucesso.']);
    } else {
      echo json_encode(['success' => false, 'message' => 'Nenhum registro encontrado para atualizar.']);
    }
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $conn->error]);
  }

} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
