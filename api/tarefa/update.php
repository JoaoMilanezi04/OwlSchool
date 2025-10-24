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


$id           = $_POST['id'];
$titulo       = $_POST['titulo'];
$descricao    = $_POST['descricao'];
$data_entrega = $_POST['data_entrega'];


if (empty($id) || empty($titulo) || empty($descricao) || empty($data_entrega)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    exit;
}


$stmt = $conn->prepare("UPDATE tarefa SET titulo = ?, descricao = ?, data_entrega = ? WHERE id = ?");
$stmt->bind_param("sssi", $titulo, $descricao, $data_entrega, $id);


if ($stmt->execute()) {
    
    if ($stmt->affected_rows > 0) {
        echo json_encode([
            "success" => true,
            "message" => "Tarefa atualizada com sucesso."
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
        "message" => "Erro ao atualizar tarefa: " . $stmt->error
    ]);
}


$stmt->close();
$conn->close();