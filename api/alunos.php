<?php
// api/alunos.php
declare(strict_types=1);

require_once __DIR__ . '/../db/conexao.php';

/** Nome do aluno vindo de usuario */
function getAlunoNome(int $alunoId): ?string {
    global $conn;
    $sql = "SELECT u.nome
              FROM aluno a
              JOIN usuario u ON u.id = a.usuario_id
             WHERE a.id = ?
             LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $alunoId);
    $stmt->execute();
    $res = $stmt->get_result();
    return ($row = $res->fetch_assoc()) ? $row['nome'] : null;
}

/** Primeiro responsável (nome) do aluno */
function getNomeResponsavel(int $alunoId): ?string {
    global $conn;
    $sql = "SELECT u.nome AS responsavel_nome
              FROM aluno_responsavel ar
              JOIN responsavel r ON r.id = ar.responsavel_id
              JOIN usuario    u ON u.id = r.usuario_id
             WHERE ar.aluno_id = ?
             ORDER BY u.nome
             LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $alunoId);
    $stmt->execute();
    $res = $stmt->get_result();
    return ($row = $res->fetch_assoc()) ? $row['responsavel_nome'] : null;
}

/** Lista completa de responsáveis (id/nome/email) */
function getResponsaveisDoAluno(int $alunoId): array {
    global $conn;
    $sql = "SELECT r.id AS responsavel_id, u.nome, u.email
              FROM aluno_responsavel ar
              JOIN responsavel r ON r.id = ar.responsavel_id
              JOIN usuario    u ON u.id = r.usuario_id
             WHERE ar.aluno_id = ?
             ORDER BY u.nome";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $alunoId);
    $stmt->execute();
    $res = $stmt->get_result();

    $out = [];
    while ($row = $res->fetch_assoc()) $out[] = $row;
    return $out;
}
