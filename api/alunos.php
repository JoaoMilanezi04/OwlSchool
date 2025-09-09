<?php
// api/alunos.php
declare(strict_types=1);

require_once __DIR__ . '/../db/conexao.php'; // carrega conexão ($conn)

/** Nome do aluno (tabela usuario via aluno.usuario_id) */
function getAlunoNome(int $alunoId): ?string {
    global $conn; // usa conexão compartilhada
    $sql = "SELECT u.nome
              FROM aluno a
              JOIN usuario u ON u.id = a.usuario_id
             WHERE a.id = ?
             LIMIT 1"; // limita a 1 resultado
    $stmt = $conn->prepare($sql);            // prepara query
    $stmt->bind_param('i', $alunoId);        // vincula id do aluno
    $stmt->execute();                        // executa
    $res = $stmt->get_result();              // pega resultado
    $row = $res->fetch_assoc();              // primeira linha ou null
    return $row['nome'] ?? null;             // retorna nome ou null
}

/** Primeiro responsável do aluno (por nome) */
function getNomeResponsavel(int $alunoId): ?string {
    global $conn; // usa conexão compartilhada
    $sql = "SELECT u.nome AS responsavel_nome
              FROM aluno_responsavel ar
              JOIN responsavel r ON r.id = ar.responsavel_id
              JOIN usuario    u ON u.id = r.usuario_id
             WHERE ar.aluno_id = ?
             ORDER BY u.nome
             LIMIT 1"; // pega o primeiro por ordem alfabética
    $stmt = $conn->prepare($sql);            // prepara query
    $stmt->bind_param('i', $alunoId);        // vincula aluno_id
    $stmt->execute();                        // executa
    $res = $stmt->get_result();              // pega resultado
    $row = $res->fetch_assoc();              // primeira linha ou null
    return $row['responsavel_nome'] ?? null; // nome do responsável ou null
}

/** Lista completa de responsáveis (id/nome/email) do aluno */
function getResponsaveisDoAluno(int $alunoId): array {
    global $conn; // usa conexão compartilhada
    $sql = "SELECT r.id AS responsavel_id, u.nome, u.email
              FROM aluno_responsavel ar
              JOIN responsavel r ON r.id = ar.responsavel_id
              JOIN usuario    u ON u.id = r.usuario_id
             WHERE ar.aluno_id = ?
             ORDER BY u.nome"; // ordena por nome
    $stmt = $conn->prepare($sql);            // prepara query
    $stmt->bind_param('i', $alunoId);        // vincula aluno_id
    $stmt->execute();                        // executa
    $res = $stmt->get_result();              // pega resultado
    return $res->fetch_all(MYSQLI_ASSOC);    // retorna lista [{responsavel_id,nome,email},...]
}
