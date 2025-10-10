<?php

require_once __DIR__ . '/../../db/conexao.php';



function deleteUsuario($usuarioId) {
    global $conn;

    $conn->query("DELETE FROM aluno WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM professor WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM responsavel WHERE usuario_id = $usuarioId");
    $conn->query("DELETE FROM usuario WHERE id = $usuarioId");

    return true;
}
