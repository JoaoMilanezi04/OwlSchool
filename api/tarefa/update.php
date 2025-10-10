<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $id           = $_POST['id'] ?? 0;
  $titulo       = $_POST['titulo'] ?? '';
  $descricao    = $_POST['descricao'] ?? '';
  $data_entrega = $_POST['data_entrega'] ?? '';

  $sql = "
    UPDATE tarefa
       SET titulo = '$titulo',
           descricao = '$descricao',
           data_entrega = '$data_entrega'
     WHERE id = $id
  ";

  if ($conn->query($sql)) {
    echo json_encode(['success' => true, 'message' => 'Tarefa atualizada com sucesso.']);
  } else {
    echo json_encode(['success' => false, 'message' => 'Erro ao atualizar: ' . $conn->error]);
  }
} else {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']);
}
