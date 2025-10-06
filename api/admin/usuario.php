<?php

require_once __DIR__ . '/../../db/conexao.php';



function listUsuarios() {
    global $conn;

    $sql = "
        SELECT
            usuario.id,
            usuario.nome,
            usuario.email,
            usuario.tipo_usuario,
            professor.telefone   AS tel_prof,
            responsavel.telefone AS tel_resp
        FROM usuario
        LEFT JOIN professor   ON professor.usuario_id   = usuario.id
        LEFT JOIN responsavel ON responsavel.usuario_id = usuario.id
        ORDER BY usuario.id ASC
    ";

    $resultado = $conn->query($sql);
    $usuarios = [];

    if ($resultado) {
        while ($linha = $resultado->fetch_assoc()) {
            $usuarios[] = $linha;
        }
    }

    return $usuarios;
}



function getUsuario($usuarioId) {
    global $conn;

    $sql = "
        SELECT 
            usuario.id,
            usuario.nome,
            usuario.email,
            usuario.tipo_usuario,
            professor.telefone   AS telefone_professor,
            responsavel.telefone AS telefone_responsavel
        FROM usuario
        LEFT JOIN professor   ON professor.usuario_id   = usuario.id
        LEFT JOIN responsavel ON responsavel.usuario_id = usuario.id
        WHERE usuario.id = $usuarioId
    ";

    $resultado = $conn->query($sql);

    if ($resultado && $resultado->num_rows > 0) {
        return $resultado->fetch_assoc();
    }

    return null;
}



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



function deleteUsuario($usuarioId) {
    global $conn;

    $conn->query("DELETE FROM aluno WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM professor WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM responsavel WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM usuario WHERE id = $usuarioId");

    return true;
}
