<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id         = $_POST['id'];
    $diaSemana  = $_POST['dia_semana'];
    $horaInicio = $_POST['inicio'];
    $horaFim    = $_POST['fim'];
    $disciplina = $_POST['disciplina'];

    $sql = "UPDATE horarios_aula
            SET dia_semana = '$diaSemana',
                inicio     = '$horaInicio',
                fim        = '$horaFim',
                disciplina = '$disciplina'
            WHERE id = $id";

    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode([
            "success" => true,
            "message" => "Horário atualizado com sucesso."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao atualizar horário: " . $conn->error
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método inválido."
    ]);
}
?>
