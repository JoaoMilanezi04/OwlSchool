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


$id   = $_POST['id'];
$data = $_POST['data'];


if (empty($id) || empty($data)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE chamada SET data = ? WHERE id = ?");
$stmt->bind_param("si", $data, $id);


if ($stmt->execute()) {

    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Chamada atualizada com sucesso."
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
        "message" => "Erro ao atualizar chamada: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();