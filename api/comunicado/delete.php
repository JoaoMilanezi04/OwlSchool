<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "DELETE FROM comunicado WHERE id = $id";
    $resultado = $conn->query($sql);

    if ($resultado) {
        echo json_encode([
            "success" => true,
            "message" => "Comunicado excluído com sucesso."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao excluir comunicado: " . $conn->error
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Método inválido."
    ]);
}
?>
