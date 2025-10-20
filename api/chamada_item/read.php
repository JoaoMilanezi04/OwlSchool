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


$chamadaId = $_POST['chamada_id'];


$stmt = $conn->prepare("
  SELECT
    chamada_item.chamada_id,
    aluno.usuario_id AS aluno_id,
    usuario.nome AS aluno_nome,
    chamada_item.status
  FROM aluno
  JOIN usuario 
    ON usuario.id = aluno.usuario_id
  LEFT JOIN chamada_item
    ON chamada_item.aluno_id = aluno.usuario_id
    AND chamada_item.chamada_id = ?
  ORDER BY usuario.nome
");
$stmt->bind_param("i", $chamadaId);
$stmt->execute();


$resultado = $stmt->get_result();



if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao buscar status dos alunos: ' . $conn->error
  ]);
  exit;
}



$itens = [];


while ($linha = $resultado->fetch_assoc()) {
  $itens[] = $linha;
}


echo json_encode([
  'success' => true,
  'itens' => $itens
]);


$stmt->close();
$conn->close();