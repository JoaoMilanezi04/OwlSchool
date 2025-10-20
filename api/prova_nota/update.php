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


$prova_id = $_POST['prova_id'];
$aluno_id = $_POST['aluno_id'];
$nota     = $_POST['nota'];


if (empty($prova_id) || empty($aluno_id) || empty($nota)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE prova_nota SET nota = ? WHERE prova_id = ? AND aluno_id = ?");
$stmt->bind_param("dii", $nota, $prova_id, $aluno_id);


if ($stmt->execute()) {
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Nota atualizada com sucesso."
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
        "message" => "Erro ao atualizar nota: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();