<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $sql = "SELECT id, titulo, data FROM prova ORDER BY data DESC, id DESC";
  $rs = $conn->query($sql);

  if ($rs) {
    $provas = [];
    while ($r = $rs->fetch_assoc()) $provas[] = $r;
    echo json_encode(['success' => true, 'provas' => $provas]);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao listar: ' . $conn->error]);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
  
}
