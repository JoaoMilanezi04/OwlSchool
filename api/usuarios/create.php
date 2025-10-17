<?php

require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {


    $nome         = $_POST['nome'] ?? '';
    $email        = $_POST['email'] ?? '';
    $senha        = $_POST['senha'] ?? '';
    $tipo_usuario = $_POST['tipo_usuario'] ?? '';
    $telefone     = $_POST['telefone'] ?? '';


    $sqlUsuario = "
        INSERT INTO usuario (nome, email, senha, tipo_usuario)
        VALUES ('$nome', '$email', '$senha', '$tipo_usuario')
    ";


    if ($conn->query($sqlUsuario)) {
        $novoUsuarioId = $conn->insert_id;


        if ($tipo_usuario === 'aluno') {
            $conn->query("INSERT INTO aluno (usuario_id) VALUES ($novoUsuarioId)");
        }


        if ($tipo_usuario === 'professor') {
            $conn->query("INSERT INTO professor (usuario_id, telefone) VALUES ($novoUsuarioId, '$telefone')");
        }


        if ($tipo_usuario === 'responsavel') {
            $conn->query("INSERT INTO responsavel (usuario_id, telefone) VALUES ($novoUsuarioId, '$telefone')");
        }


        echo json_encode([
            'success' => true,
            'message' => 'Usuário criado com sucesso.',
            'id' => $novoUsuarioId
        ]);



    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Erro ao criar usuário: ' . $conn->error
        ]);
    }



} else {
    echo json_encode([
        'success' => false,
        'message' => 'Método inválido.'
    ]);
}
