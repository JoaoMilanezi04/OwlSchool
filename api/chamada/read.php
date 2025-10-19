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


$stmt = $conn->prepare("SELECT id, data FROM chamada ORDER BY data DESC, id DESC");
$stmt->execute();


$resultado = $stmt->get_result();
$chamadas = [];


while ($linha = $resultado->fetch_assoc()) {
  $chamadas[] = $linha;
}


echo json_encode([
  'success' => true,
  'chamadas' => $chamadas
]);


$stmt->close();
$conn->close();
