<?php
require_once __DIR__ . '/../../db/conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
  exit;
}


$sql = "SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC";
$resultado = $conn->query($sql);

if (!$resultado) {
  echo json_encode(['success' => false, 'message' => 'Erro ao listar: ' . $conn->error]);
  exit;
}

$comunicados = [];
while ($linha = $resultado->fetch_assoc()) {
  $comunicados[] = $linha;
}

echo json_encode([
  'success' => true,
  'comunicados' => $comunicados,
  'tipo_usuario' => $_SESSION['tipo_usuario']
]);
