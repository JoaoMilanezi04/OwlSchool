<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode(['success' => false, 'message' => 'Método inválido.']); exit;
}

$prova_id = (int)($_POST['prova_id'] ?? 0);
if ($prova_id <= 0) {
  echo json_encode(['success' => false, 'message' => 'O campo prova_id é obrigatório.']); exit;
}

/* 1) Pega o título uma vez (garante 1x no JSON) */
$titulo_prova = '';
if ($rs = $conn->query("SELECT titulo FROM prova WHERE id = $prova_id LIMIT 1")) {
  if ($rs->num_rows) {
    $titulo_prova = $rs->fetch_assoc()['titulo'];
  }
}

/* 2) Lista alunos + nota (sem título em cada linha) */
$sql = "
  SELECT 
    aluno.usuario_id AS aluno_id,
    usuario.nome     AS aluno_nome,
    prova_nota.nota  AS nota
  FROM aluno
  JOIN usuario ON usuario.id = aluno.usuario_id
  LEFT JOIN prova_nota
         ON prova_nota.aluno_id = aluno.usuario_id
        AND prova_nota.prova_id = $prova_id
  ORDER BY usuario.nome
";

$rsNotas = $conn->query($sql);
if (!$rsNotas) {
  echo json_encode(['success' => false, 'message' => 'Erro ao listar: ' . $conn->error]); exit;
}

$notas = [];
while ($linha = $rsNotas->fetch_assoc()) {
  $nota = $linha['nota'];
  if ($nota !== null) $nota = (float)$nota;

  $notas[] = [
    'aluno_id'   => (int)$linha['aluno_id'],
    'aluno_nome' => $linha['aluno_nome'],
    'nota'       => $nota,
  ];
}

echo json_encode([
  'success'      => true,
  'prova_id'     => $prova_id,
  'titulo_prova' => $titulo_prova,
  'notas'        => $notas,
]);
