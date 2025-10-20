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


$stmt = $conn->prepare("SELECT id, titulo, descricao, data_entrega FROM tarefa ORDER BY id DESC");
$stmt->execute();


$resultado = $stmt->get_result();


if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao listar tarefas: ' . $conn->error
  ]);
  exit;
}


$tarefas = [];


while ($linha = $resultado->fetch_assoc()) {
  $tarefas[] = $linha;
}


echo json_encode([
  'success' => true,
  'tarefas' => $tarefas,
  'tipo_usuario' => $_SESSION['tipo_usuario']
]);


$stmt->close();
$conn->close();