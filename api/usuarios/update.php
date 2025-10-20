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


$id           = $_POST['id']           ?? 0;
$nome         = $_POST['nome']         ?? '';
$email        = $_POST['email']        ?? '';
$senha        = $_POST['senha']        ?? '';
$tipo_usuario = $_POST['tipo_usuario'] ?? '';
$telefone     = $_POST['telefone']     ?? '';


if (empty($id) || empty($nome) || empty($email) || empty($tipo_usuario)) {
    echo json_encode([
        "success" => false,
        "message" => "Campos obrigatórios ausentes."
    ]);
    $conn->close();
    exit;
}


$id = (int)$id;



if ($senha !== '') {
    $stmtUsuario = $conn->prepare("
        UPDATE usuario
           SET nome = ?, email = ?, senha = ?, tipo_usuario = ?
         WHERE id = ?
    ");
    $stmtUsuario->bind_param("ssssi", $nome, $email, $senha, $tipo_usuario, $id);

} else {
    $stmtUsuario = $conn->prepare("
        UPDATE usuario
           SET nome = ?, email = ?, tipo_usuario = ?
         WHERE id = ?
    ");
    $stmtUsuario->bind_param("sssi", $nome, $email, $tipo_usuario, $id);
}


if (!$stmtUsuario->execute()) {
    echo json_encode([
        "success" => false,
        "message" => "Erro ao atualizar usuário: " . $stmtUsuario->error
    ]);
    $stmtUsuario->close();
    $conn->close();
    exit;
}

$stmtUsuario->close();


// Remover vínculos antigos
$conn->query("DELETE FROM aluno WHERE usuario_id = $id");
$conn->query("DELETE FROM professor WHERE usuario_id = $id");
$conn->query("DELETE FROM responsavel WHERE usuario_id = $id");


if ($tipo_usuario === 'aluno') {

    $stmtVinc = $conn->prepare("
        INSERT INTO aluno (usuario_id) VALUES (?)
    ");
    $stmtVinc->bind_param("i", $id);

} elseif ($tipo_usuario === 'professor') {

    $stmtVinc = $conn->prepare("
        INSERT INTO professor (usuario_id, telefone) VALUES (?, ?)
    ");
    $stmtVinc->bind_param("is", $id, $telefone);

} elseif ($tipo_usuario === 'responsavel') {

    $stmtVinc = $conn->prepare("
        INSERT INTO responsavel (usuario_id, telefone) VALUES (?, ?)
    ");
    $stmtVinc->bind_param("is", $id, $telefone);
}


if (isset($stmtVinc)) {
    if (!$stmtVinc->execute()) {
        echo json_encode([
            "success" => false,
            "message" => "Erro ao atualizar vínculo: " . $stmtVinc->error
        ]);
        $stmtVinc->close();
        $conn->close();
        exit;
    }
    $stmtVinc->close();
}


echo json_encode([
    "success" => true,
    "message" => "Usuário atualizado com sucesso."
]);


$conn->close();
?>
