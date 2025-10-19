<?php
require_once __DIR__ . '/../../../db/conexao.php';

session_start();

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Método inválido.'
  ]);
  exit;
}


$responsavelId = (int) $_SESSION['user_id'];


$stmt = $conn->prepare("
  SELECT
    prova.id AS prova_id,
    prova.titulo AS titulo,
    prova.data AS data,
    prova_nota.nota AS nota,
    usuario.nome AS aluno_nome
  FROM aluno_responsavel
  JOIN prova_nota
    ON prova_nota.aluno_id = aluno_responsavel.aluno_id
  JOIN prova
    ON prova.id = prova_nota.prova_id
  JOIN usuario
    ON usuario.id = aluno_responsavel.aluno_id
  WHERE aluno_responsavel.responsavel_id = ?
  ORDER BY prova.data DESC
");
$stmt->bind_param("i", $responsavelId);
$stmt->execute();


$resultado = $stmt->get_result();
$notas = [];


while ($linha = $resultado->fetch_assoc()) {
  $notas[] = $linha;
}


echo json_encode([
  'success' => true,
  'notas' => $notas
]);


$stmt->close();
$conn->close();
