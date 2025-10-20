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


$id         = $_POST['id'];
$diaSemana  = $_POST['dia_semana'];
$horaInicio = $_POST['inicio'];
$horaFim    = $_POST['fim'];
$disciplina = $_POST['disciplina'];


if (empty($id) || empty($diaSemana) || empty($horaInicio) || empty($horaFim) || empty($disciplina)) {
  echo json_encode([
    "success" => false,
    "message" => "Campos obrigatórios ausentes."
  ]);
  exit;
}


$stmt = $conn->prepare("
    UPDATE horarios_aula
       SET dia_semana = ?, inicio = ?, fim = ?, disciplina = ?
     WHERE id = ?
");
$stmt->bind_param("ssssi", $diaSemana, $horaInicio, $horaFim, $disciplina, $id);



if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Horário atualizado com sucesso."
        ]);

    } else {
        echo json_encode([
            "success" => false,
            "message" => "Nenhum elemento encontrado para atualizar."
        ]);
    }

} else {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar horário: " . $stmt->error
    ]);
}



$stmt->close();
$conn->close();