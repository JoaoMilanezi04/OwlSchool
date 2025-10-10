<?php

require_once __DIR__ . '/../../db/conexao.php';



function updateUsuario($usuarioId, $nome, $email, $senhaOpcional, $tipoUsuario, $telefoneOpcional = null) {
    global $conn;

    if ($senhaOpcional !== '') {
        $sql = "
            UPDATE usuario
               SET nome = '$nome',
                   email = '$email',
                   senha = '$senhaOpcional',
                   tipo_usuario = '$tipoUsuario'
             WHERE id = $usuarioId
        ";
    } else {
        $sql = "
            UPDATE usuario
               SET nome = '$nome',
                   email = '$email',
                   tipo_usuario = '$tipoUsuario'
             WHERE id = $usuarioId
        ";
    }

    $conn->query($sql);

    $conn->query("DELETE FROM aluno WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM professor WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM responsavel WHERE usuario_id = $usuarioId");

    if ($tipoUsuario === 'aluno') {
        $conn->query("INSERT INTO aluno (usuario_id) VALUES ($usuarioId)");
    }

    if ($tipoUsuario === 'professor') {
        if (!$telefoneOpcional) return false;
        $conn->query("INSERT INTO professor (usuario_id, telefone) VALUES ($usuarioId, '$telefoneOpcional')");
    }

    if ($tipoUsuario === 'responsavel') {
        if (!$telefoneOpcional) return false;
        $conn->query("INSERT INTO responsavel (usuario_id, telefone) VALUES ($usuarioId, '$telefoneOpcional')");
    }

    return true;
}
