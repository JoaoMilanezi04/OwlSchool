<?php

require_once __DIR__ . '/../db/conexao.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

if (empty($_SESSION['user_id'])) {
    header('Location: ../public/index.php?erro=login');
    exit;
}

if (empty($_SESSION['tipo_usuario']) || $_SESSION['tipo_usuario'] !== 'professor') {
    header('Location: ../public/index.php?erro=permissao');
    exit;
}

if (empty($_SESSION['turma_id'])) {
    $sql = "
      SELECT id
        FROM turma
       WHERE professor_id_responsavel = " . $_SESSION['user_id'] . "
       LIMIT 1
    ";
    $resultado = $conn->query($sql);
    $turma     = $resultado ? $resultado->fetch_assoc() : null;

    if (!$turma) {
        header('Location: ../public/index.php?erro=sem_turma');
        exit;
    }

    $_SESSION['turma_id'] = $turma['id'];
}
