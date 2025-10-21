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


$stmt = $conn->prepare("SELECT id, titulo, data FROM prova ORDER BY data DESC, id DESC");
$stmt->execute();


$resultado = $stmt->get_result();


if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao buscar provas: ' . $conn->error
  ]);
  exit;
}


$provas = [];


while ($linha = $resultado->fetch_assoc()) {
  $provas[] = $linha;
}


echo json_encode([
  'success' => true,
  'provas' => $provas
]);


$stmt->close();
$conn->close();