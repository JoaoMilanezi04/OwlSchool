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


$stmt = $conn->prepare("
  SELECT
    aluno.usuario_id AS aluno_id,
    usuario.nome AS aluno_nome
  FROM aluno
  JOIN usuario 
    ON usuario.id = aluno.usuario_id
  ORDER BY usuario.nome ASC
");
$stmt->execute();


$resultado = $stmt->get_result();


if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao listar alunos: ' . $conn->error
  ]);
  exit;
}

$alunos = [];


while ($linha = $resultado->fetch_assoc()) {
  $alunos[] = $linha;
}


if (count($alunos) > 0) {
  echo json_encode([
    'success' => true,
    'alunos' => $alunos
  ]);

} else {
  echo json_encode([
    'success' => false,
    'message' => 'Nenhum aluno encontrado.'
  ]);
}


$stmt->close();
$conn->close();