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


$titulo_prova = null;

$buscaTitulo = $conn->prepare("SELECT titulo FROM prova WHERE id = ?");
$buscaTitulo->bind_param("i", $prova_id);
$buscaTitulo->execute();

$resTitulo = $buscaTitulo->get_result();

if ($resTitulo && $row = $resTitulo->fetch_assoc()) {$titulo_prova = $row['titulo'];}

$buscaTitulo->close();


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
    'message' => 'Erro ao listar notas: ' . $conn->error
  ]);
  exit;
}

$notas = [];


while ($linha = $resultado->fetch_assoc()) {
  $nota = $linha['nota'];
  if ($nota !== null) $nota = (float)$nota;

  
  $notas[] = [
    'aluno_id' => $linha['aluno_id'],
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