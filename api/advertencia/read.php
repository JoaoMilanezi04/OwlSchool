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
    advertencia.id,
    advertencia.titulo,
    advertencia.descricao,
    usuario.nome AS aluno_nome
  FROM advertencia
  LEFT JOIN aluno_advertencia
    ON aluno_advertencia.advertencia_id = advertencia.id
  LEFT JOIN usuario
    ON usuario.id = aluno_advertencia.aluno_id
  ORDER BY advertencia.id DESC
");
$stmt->execute();


$resultado = $stmt->get_result();


if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao buscar advertências: ' . $conn->error
  ]);
  exit;
}


$advertencias = [];


while ($linha = $resultado->fetch_assoc()) {
  $advertencias[] = $linha;
}


echo json_encode([
  'success' => true,
  'advertencias' => $advertencias
]);


$stmt->close();
$conn->close();