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


$usuarioId = $_SESSION['user_id'];


$stmt = $conn->prepare("
  SELECT
    aluno_advertencia.advertencia_id AS id,
    advertencia.titulo AS titulo,
    advertencia.descricao AS descricao,
    usuario.nome AS aluno_nome
  FROM aluno
  JOIN aluno_advertencia
    ON aluno_advertencia.aluno_id = aluno.usuario_id
  JOIN advertencia
    ON advertencia.id = aluno_advertencia.advertencia_id
  JOIN usuario
    ON usuario.id = aluno.usuario_id
  WHERE aluno.usuario_id = ?
  ORDER BY advertencia.id DESC
");
$stmt->bind_param("i", $usuarioId);
$stmt->execute();


$resultado = $stmt->get_result();
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
