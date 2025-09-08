<?php
declare(strict_types=1);

/** Garante sessão ativa uma única vez. */
function ensure_session(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) session_start();
}

/** Exige usuário logado. Redireciona ao login se não estiver. */
function require_login(): void {
    ensure_session();
    if (!isset($_SESSION['user_id'])) {
        header('Location: /index.php?erro=usuario');
        exit;
    }
}

/**
 * Exige papel específico (string) ou um de uma lista (array).
 * Ex.: require_role('aluno') ou require_role(['admin','professor'])
 */
function require_role(string|array $roles): void {
    ensure_session();
    $roles = (array) $roles;
    $role  = $_SESSION['role'] ?? null;
    if (!in_array($role, $roles, true)) {
        http_response_code(403);
        echo '<h1>403 - Acesso negado</h1>';
        exit;
    }
}

/** Helper: pega ID da entidade do papel atual (se houver). */
function session_entity_id(string $key): ?int {
    ensure_session();
    $val = $_SESSION[$key] ?? null;
    return is_numeric($val) ? (int)$val : null;
}
