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


$prova_id = $_POST['prova_id'];

$titulo_prova = '';

$stmtTitulo = $conn->prepare("SELECT titulo FROM prova WHERE id = ? LIMIT 1");
$stmtTitulo->bind_param("i", $prova_id);
$stmtTitulo->execute();

$rsTitulo = $stmtTitulo->get_result();

if ($rsTitulo && $rsTitulo->num_rows) {
  $titulo_prova = $rsTitulo->fetch_assoc()['titulo'];
}

$stmtTitulo->close();


$stmt = $conn->prepare("
  SELECT 
    aluno.usuario_id AS aluno_id,
    usuario.nome     AS aluno_nome,
    prova_nota.nota  AS nota
  FROM aluno
  JOIN usuario 
    ON usuario.id = aluno.usuario_id
  LEFT JOIN prova_nota
    ON prova_nota.aluno_id = aluno.usuario_id
    AND prova_nota.prova_id = ?
  ORDER BY usuario.nome
");
$stmt->bind_param("i", $prova_id);
$stmt->execute();


$resultado = $stmt->get_result();

if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao listar: ' . $conn->error
  ]);
  exit;
}


$notas = [];


while ($linha = $resultado->fetch_assoc()) {
  $nota = $linha['nota'];
  if ($nota !== null) $nota = (float)$nota;

  $notas[] = [
    'aluno_id' => (int)$linha['aluno_id'],
    'aluno_nome' => $linha['aluno_nome'],
    'nota' => $nota
  ];
}


echo json_encode([
  'success' => true,
  'prova_id' => $prova_id,
  'titulo_prova' => $titulo_prova,
  'notas' => $notas
]);


$stmt->close();
$conn->close();
