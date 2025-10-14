<?php

require_once __DIR__ . '/../../db/conexao.php';

header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $id           = $_POST['id'];
    $nome         = $_POST['nome'];
    $email        = $_POST['email'];
    $senha        = $_POST['senha'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'];
    $telefone     = $_POST['telefone'] ?? '';


    if ($senha !== '') {
        $sqlUsuario = "
            UPDATE usuario
               SET nome = '$nome',
                   email = '$email',
                   senha = '$senha',
                   tipo_usuario = '$tipo_usuario'
             WHERE id = $id
        ";


    } else {
        $sqlUsuario = "
            UPDATE usuario
               SET nome = '$nome',
                   email = '$email',
                   tipo_usuario = '$tipo_usuario'
             WHERE id = $id
        ";
    }


    if (!$conn->query($sqlUsuario)) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao atualizar usuário: ' . $conn->error
        ]);
        exit;
    }


    $conn->query("DELETE FROM aluno WHERE usuario_id = $id");
    $conn->query("DELETE FROM professor WHERE usuario_id = $id");
    $conn->query("DELETE FROM responsavel WHERE usuario_id = $id");


    if ($tipo_usuario === 'aluno') {
        $sqlVinc = "INSERT INTO aluno (usuario_id) VALUES ($id)";
    }


    if ($tipo_usuario === 'professor') {
        $sqlVinc = "INSERT INTO professor (usuario_id, telefone) VALUES ($id, '$telefone')";
    }


    if ($tipo_usuario === 'responsavel') {
        $sqlVinc = "INSERT INTO responsavel (usuario_id, telefone) VALUES ($id, '$telefone')";
    }


    if (isset($sqlVinc) && !$conn->query($sqlVinc)) {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao atualizar vínculo: ' . $conn->error
        ]);
        exit;
    }


    echo json_encode([
        'success' => true,
        'message' => 'Usuário atualizado com sucesso.'
    ]);


} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
