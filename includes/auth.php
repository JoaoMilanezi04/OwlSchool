<?php
// includes/auth.php — DEMO ultra simples

// sempre garante sessão ativa
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// exige login (senão volta pro index)
function require_login() {
    if (empty($_SESSION['user_id'])) {
        header('Location: /public/index.php?erro=login');
        exit;
    }
}

// exige papel específico (ex: 'aluno', 'professor', 'admin')
function require_role($role) {
    $current = $_SESSION['tipo_usuario'] ?? null;
    if ($current !== $role && (!is_array($role) || !in_array($current, $role))) {
        header('Location: /public/index.php?erro=permissao');
        exit;
    }
}
