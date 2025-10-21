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


$chamadaId = $_POST['chamada_id'];
$alunoId   = $_POST['aluno_id'];
$status    = $_POST['status'];


if (empty($chamadaId) || empty($alunoId) || empty($status)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE chamada_item SET status = ? WHERE chamada_id = ? AND aluno_id = ?");
$stmt->bind_param("sii", $status, $chamadaId, $alunoId);


if ($stmt->execute()) {
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Status de presença atualizado com sucesso."
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
        "message" => "Erro ao atualizar presença: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();