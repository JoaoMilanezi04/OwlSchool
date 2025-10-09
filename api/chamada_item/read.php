<?php
require __DIR__ . '/../../db/conexao.php';

/**
 * Lista todos os alunos com o status daquela chamada.
 * Retorna: aluno_id, nome, status ('presente'|'falta'|NULL), lancada (0|1)
 */
function readStatusByChamada($chamadaId) {
  global $conn;
  $chamadaId = (int)$chamadaId;
  $sql = "
    SELECT
      a.usuario_id AS aluno_id,
      COALESCE(u.nome, CONCAT('Aluno #', a.usuario_id)) AS nome,
      ci.status,
      IF(ci.status IS NULL, 0, 1) AS lancada
    FROM aluno a
    LEFT JOIN usuario u ON u.id = a.usuario_id
    LEFT JOIN chamada_item ci
           ON ci.aluno_id   = a.usuario_id
          AND ci.chamada_id = $chamadaId
    ORDER BY nome ASC, aluno_id ASC
  ";
  $res = $conn->query($sql);
  $rows = [];
  if ($res) while ($r = $res->fetch_assoc()) $rows[] = $r;
  return $rows;
}

/**
 * Lista o histórico de presença de um aluno em todas as chamadas.
 * Retorna: chamada_id, data, status ('presente'|'falta'|NULL)
 */
function readStatusByAluno($alunoId) {
  global $conn;
  $alunoId = (int)$alunoId;
  $sql = "
    SELECT
      c.id   AS chamada_id,
      c.data AS data,
      ci.status
    FROM chamada c
    LEFT JOIN chamada_item ci
           ON ci.chamada_id = c.id
          AND ci.aluno_id   = $alunoId
    ORDER BY c.data DESC, c.id DESC
  ";
  $res = $conn->query($sql);
  $rows = [];
  if ($res) while ($r = $res->fetch_assoc()) $rows[] = $r;
  return $rows;
}
