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


$id     = $_POST['id'];
$titulo = $_POST['titulo'];
$corpo  = $_POST['corpo'];


if (empty($id) || empty($titulo) || empty($corpo)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE comunicado SET titulo = ?, corpo = ? WHERE id = ?");
$stmt->bind_param("ssi", $titulo, $corpo, $id);


if ($stmt->execute()) {
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Comunicado atualizado com sucesso."
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
        "message" => "Erro ao atualizar comunicado: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();