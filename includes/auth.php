<?php
declare(strict_types=1);

/** Garante sessão ativa uma única vez. */
function ensure_session(): void {
    if (session_status() !== PHP_SESSION_ACTIVE) { session_start(); } // inicia se ainda não estiver ativa
}

/** Exige usuário logado. Redireciona ao login se não estiver. */
function require_login(): void {
    ensure_session();                                // garante sessão
    if (!isset($_SESSION['user_id'])) {              // sem usuário logado?
        header('Location: /index.php?erro=usuario'); // volta pro login com erro
        exit;                                        // encerra execução
    }
}

/**
 * Exige papel específico (string) ou um de uma lista (array).
 * Ex.: require_role('aluno') ou require_role(['admin','professor'])
 */
function require_role(string|array $roles): void {
    ensure_session();                      // garante sessão
    $roles = (array) $roles;               // normaliza para array
    $role  = $_SESSION['role'] ?? null;    // papel atual da sessão
    if (!in_array($role, $roles, true)) {  // papel não permitido?
        http_response_code(403);           // resposta 403 (acesso negado)
        echo '<h1>403 - Acesso negado</h1>'; // mensagem simples
        exit;                               // encerra execução
    }
}

/** Helper: pega ID da entidade do papel atual (se houver). */
function session_entity_id(string $key): ?int {
    ensure_session();                          // garante sessão
    $val = $_SESSION[$key] ?? null;            // lê valor bruto
    return is_numeric($val) ? (int)$val : null; // converte para int ou null
}
