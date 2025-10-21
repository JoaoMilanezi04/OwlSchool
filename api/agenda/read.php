<?php
require_once __DIR__ . '/../../db/conexao.php';
session_start();

header('Content-Type: application/json; charset=utf-8');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    'success' => false,
    'message' => 'Método inválido.',
    'tipo_usuario' => $_SESSION['tipo_usuario']
  ]);
  exit;
}


$stmt = $conn->prepare("
  SELECT 
    id,
    dia_semana,
    TIME_FORMAT(inicio, '%H:%i') AS inicio,
    TIME_FORMAT(fim, '%H:%i')   AS fim,
    disciplina
  FROM horarios_aula
  ORDER BY FIELD(dia_semana,'segunda','terca','quarta','quinta','sexta'), inicio
");
$stmt->execute();


$resultado = $stmt->get_result();


if (!$resultado) {
  echo json_encode([
    'success' => false,
    'message' => 'Erro ao buscar horários: ' . $conn->error
  ]);
  exit;
}


$porDia = ['segunda'=>[], 'terca'=>[], 'quarta'=>[], 'quinta'=>[], 'sexta'=>[]];


while ($linha = $resultado->fetch_assoc()) {
  $porDia[$linha['dia_semana']][] = $linha;
}


echo json_encode([
  'success' => true,
  'por_dia' => $porDia,
  'tipo_usuario' => $_SESSION['tipo_usuario']
]);


$stmt->close();
$conn->close();