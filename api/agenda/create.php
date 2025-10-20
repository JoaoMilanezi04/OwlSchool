<?php
require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  echo json_encode([
    "success" => false,
    "message" => "Método inválido."
  ]);
  exit;
}


$diaSemana  = $_POST['dia_semana'] ?? '';
$horaInicio = $_POST['inicio'] ?? '';
$horaFim    = $_POST['fim'] ?? '';
$disciplina = $_POST['disciplina'] ?? '';


if (empty($diaSemana) || empty($horaInicio) || empty($horaFim) || empty($disciplina)) {
  echo json_encode([
    "success" => false,
    "message" => "Campos obrigatórios ausentes."
  ]);
  exit;
}


$stmt = $conn->prepare("INSERT INTO horarios_aula (dia_semana, inicio, fim, disciplina) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $diaSemana, $horaInicio, $horaFim, $disciplina);


if ($stmt->execute()) {
  echo json_encode([
    "success" => true,
    "message" => "Horário criado com sucesso.",
    "id" => $conn->insert_id
  ]);
  
} else {
  echo json_encode([
    "success" => false,
    "message" => "Erro ao criar horário: " . $stmt->error
  ]);
}


$stmt->close();
$conn->close();
