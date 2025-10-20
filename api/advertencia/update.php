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


$id        = $_POST['id'] ?? '';
$titulo    = $_POST['titulo'] ?? '';
$descricao = $_POST['descricao'] ?? '';

if (empty($id) || empty($titulo) || empty($descricao)) {
    echo json_encode([
        'success' => false,
        'message' => 'Campos obrigatórios ausentes.'
    ]);
    // fechar conexão por precaução
    if (isset($conn) && $conn instanceof mysqli) {
        $conn->close();
    }
    exit;
}

// garantir tipos corretos
$id = (int)$id;

// prepared statement pra evitar SQL injection
$stmt = $conn->prepare("UPDATE advertencia SET titulo = ?, descricao = ? WHERE id = ?");
if ($stmt === false) {
    echo json_encode([
        'success' => false,
        'message' => 'Erro na preparação da query: ' . $conn->error
    ]);
    $conn->close();
    exit;
}

$stmt->bind_param("ssi", $titulo, $descricao, $id);

if ($stmt->execute()) {
    echo json_encode([
        'success' => true,
        'message' => 'Advertência atualizada com sucesso.'
    ]);
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Erro ao atualizar: ' . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
