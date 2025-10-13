<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $diaSemana  = $_POST['dia_semana'];
    $horaInicio = $_POST['inicio'];
    $horaFim    = $_POST['fim'];
    $disciplina = $_POST['disciplina'];

    $sql = "INSERT INTO horarios_aula (dia_semana, inicio, fim, disciplina)
            VALUES ('$diaSemana', '$horaInicio', '$horaFim', '$disciplina')";

    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode([
            "success" => true,
            "message" => "Horário criado com sucesso.",
            "id" => $conn->insert_id
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao criar horário: " . $conn->error
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método inválido."
    ]);
}
?>
