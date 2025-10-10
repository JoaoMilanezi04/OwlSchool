<?php

require_once __DIR__ . '/../../db/conexao.php';




function createUsuario($nome, $email, $senha, $tipoUsuario, $telefone = null) {
    global $conn;

    $sqlUsuario = "
        INSERT INTO usuario (nome, email, senha, tipo_usuario)
        VALUES ('$nome', '$email', '$senha', '$tipoUsuario')
    ";

    $conn->query($sqlUsuario);
    $novoUsuarioId = $conn->insert_id;

    if ($tipoUsuario === 'aluno') {
        $conn->query("INSERT INTO aluno (usuario_id) VALUES ($novoUsuarioId)");
    }

    if ($tipoUsuario === 'professor') {
        if (!$telefone) return null;
        $conn->query("INSERT INTO professor (usuario_id, telefone) VALUES ($novoUsuarioId, '$telefone')");
    }

    if ($tipoUsuario === 'responsavel') {
        if (!$telefone) return null;
        $conn->query("INSERT INTO responsavel (usuario_id, telefone) VALUES ($novoUsuarioId, '$telefone')");
    }

    return $novoUsuarioId;
}