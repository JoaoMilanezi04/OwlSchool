<?php

require_once __DIR__ . '/../../db/conexao.php';


function createOrUpdateAlunoAdvertencia(int $advertenciaId, int $alunoId) {
  global $conn;
  $advertenciaId = (int)$advertenciaId;
  $alunoId = (int)$alunoId;
  $sql = "
    INSERT INTO aluno_advertencia (advertencia_id, aluno_id)
    VALUES ($advertenciaId, $alunoId)
    ON DUPLICATE KEY UPDATE aluno_id = VALUES(aluno_id)
  ";
  return $conn->query($sql);
}


function saveAdvertidosEmMassa(int $advertenciaId, array $alunosMarcados) {
  global $conn;
  // Apaga todos
  $conn->query("DELETE FROM aluno_advertencia WHERE advertencia_id=$advertenciaId");
  // Reinsere os marcados
  foreach ($alunosMarcados as $alunoId => $checked) {
    if ($checked == '1') createOrUpdateAlunoAdvertencia($advertenciaId, (int)$alunoId);
  }
}