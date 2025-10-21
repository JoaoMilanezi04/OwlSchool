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


$titulo         = $_POST['titulo'];
$descricao      = $_POST['descricao'];
$alunoUsuarioId = $_POST['aluno_id'];


if (empty($titulo) || empty($descricao) || empty($alunoUsuarioId)) {
  echo json_encode([
    'success' => false,
    'message' => 'Campos obrigatórios ausentes.'
  ]);
  exit;
}


$stmt1 = $conn->prepare("INSERT INTO advertencia (titulo, descricao) VALUES (?, ?)");
$stmt1->bind_param("ss", $titulo, $descricao);


if ($stmt1->execute()) {
  $advertenciaId = $conn->insert_id;
  $stmt1->close();


  $stmt2 = $conn->prepare("INSERT INTO aluno_advertencia (advertencia_id, aluno_id) VALUES (?, ?)");
  $stmt2->bind_param("ii", $advertenciaId, $alunoUsuarioId);


  if ($stmt2->execute()) {
    echo json_encode([
      'success' => true,
      'message' => 'Advertência criada e vinculada com sucesso.',
    ]);

  } else {
    echo json_encode([
      'success' => false,
      'message' => 'Erro ao vincular aluno: ' . $stmt2->error
    ]);
  }


  $stmt2->close();


} else {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao criar advertência: ' . $stmt1->error
  ]);
  $stmt1->close();
}


$conn->close();