<?php


require __DIR__ . '/../../db/conexao.php';




function readNotasByProva($provaId) {
  global $conn;
  $sql = "
    SELECT
      a.usuario_id AS aluno_id,
      COALESCE(u.nome, CONCAT('Aluno #', a.usuario_id)) AS nome,
      pn.nota,
      IF(pn.nota IS NULL, 0, 1) AS lancada
    FROM aluno a
    LEFT JOIN usuario u ON u.id = a.usuario_id
    LEFT JOIN prova_nota pn
           ON pn.aluno_id = a.usuario_id
          AND pn.prova_id = $provaId
    ORDER BY nome ASC, aluno_id ASC
  ";
  $res = $conn->query($sql);
  $rows = [];
  while ($r = $res->fetch_assoc()) $rows[] = $r;
  return $rows;
}




function readNotasByAluno($alunoId) {
    global $conn;
    $sql = "SELECT prova_id, aluno_id, nota
            FROM prova_nota
            WHERE aluno_id = $alunoId
            ORDER BY prova_id DESC";
    $res = $conn->query($sql);
    $rows = [];
    while ($r = $res->fetch_assoc()) $rows[] = $r;
    return $rows;
}





function listProvasENotasDoAluno($alunoId) {
    global $conn;
    $sql = "
        SELECT 
            prova.id AS prova_id,
            prova.titulo AS titulo,
            prova.data AS data,
            prova_nota.nota AS nota
        FROM prova
        LEFT JOIN prova_nota 
          ON prova_nota.prova_id = prova.id 
         AND prova_nota.aluno_id = $alunoId
    ";
    $resultado = $conn->query($sql);
    $lista = [];
    while ($linha = $resultado->fetch_assoc()) $lista[] = $linha;
    return $lista;
}




function mediaNotasDoAluno($alunoId) {
    global $conn;
    $sql = "SELECT AVG(nota) AS media FROM prova_nota WHERE aluno_id = $alunoId";
    $resultado = $conn->query($sql);
    $linha = $resultado->fetch_assoc();
    return $linha['media'];
}
