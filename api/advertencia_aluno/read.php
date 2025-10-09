<?php

require_once __DIR__ . '/../../db/conexao.php';


function listAlunosByAdvertencia(int $advertenciaId): array {
  global $conn;
  $advertenciaId = (int)$advertenciaId;
  $sql = "
    SELECT a.usuario_id AS aluno_id, COALESCE(u.nome, CONCAT('Aluno #', a.usuario_id)) AS nome,
           CASE WHEN aa.aluno_id IS NULL THEN 0 ELSE 1 END AS advertido
    FROM aluno a
    LEFT JOIN usuario u ON u.id = a.usuario_id
    LEFT JOIN aluno_advertencia aa
           ON aa.aluno_id = a.usuario_id
          AND aa.advertencia_id = $advertenciaId
    ORDER BY nome
  ";
  $res = $conn->query($sql);
  $out = [];
  if ($res) while ($r = $res->fetch_assoc()) $out[] = $r;
  return $out;
}


function readAdvertenciasFilho($responsavelId) {
    global $conn;
    $alunoId = getIdFilho($responsavelId);
    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia, advertencia
            WHERE aluno_advertencia.advertencia_id = advertencia.id
              AND aluno_advertencia.aluno_id = $alunoId";
    $resultado = $conn->query($sql);
    $lista = [];
    while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}



function readAdvertenciasAluno($alunoId) {
    global $conn;

    $sql = "SELECT advertencia.titulo, advertencia.descricao
            FROM aluno_advertencia
            INNER JOIN advertencia ON aluno_advertencia.advertencia_id = advertencia.id
            WHERE aluno_advertencia.aluno_id = $alunoId";

    $resultado = $conn->query($sql);

    $lista = [];
    while ($linha = $resultado->fetch_assoc()) {
        $lista[] = $linha;
    }

    return $lista;
}