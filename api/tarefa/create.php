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


$titulo       = $_POST['titulo'];
$descricao    = $_POST['descricao'];
$data_entrega = $_POST['data_entrega'];


if (empty($titulo) || empty($descricao) || empty($data_entrega)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO tarefa (titulo, descricao, data_entrega) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $titulo, $descricao, $data_entrega);


if ($stmt->execute()) {

  if ($stmt->affected_rows > 0) {
    echo json_encode([
      'success' => true,
      'message' => 'Tarefa criada com sucesso.'
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Nenhuma tarefa criada.'
    ]);
  }

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar tarefa: ' . $stmt->error
  ]);
}



$stmt->close();
$conn->close();