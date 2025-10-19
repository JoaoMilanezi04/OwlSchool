<?php
require_once __DIR__ . '/../../db/conexao.php';

session_start();

header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Método inválido.'
  ]);
  exit;
}


$stmt = $conn->prepare("SELECT id, titulo, corpo FROM comunicado ORDER BY id DESC");
$stmt->execute();


$resultado = $stmt->get_result();


$comunicados = [];


while ($linha = $resultado->fetch_assoc()) {
  $comunicados[] = $linha;
}


echo json_encode([
  'success' => true,
  'comunicados' => $comunicados,
  'tipo_usuario' => $_SESSION['tipo_usuario']
]);


$stmt->close();
$conn->close();
