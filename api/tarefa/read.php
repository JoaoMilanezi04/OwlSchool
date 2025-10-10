<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

// pode ser acessado via GET (ou POST se preferir)
$sql = "SELECT id, titulo, descricao, data_entrega FROM tarefa ORDER BY id DESC";
$res = $conn->query($sql);

$tarefas = [];
if ($res) {
  while ($row = $res->fetch_assoc()) $tarefas[] = $row;
  echo json_encode(['success' => true, 'tarefas' => $tarefas]);
} else {
  echo json_encode(['success' => false, 'message' => 'Erro ao listar: ' . $conn->error]);
}
