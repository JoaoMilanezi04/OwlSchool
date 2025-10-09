<?php

require_once __DIR__ . '/../../db/conexao.php';



function deleteAlunoAdvertencia(int $advertenciaId, int $alunoId) {
  global $conn;
  $advertenciaId = (int)$advertenciaId;
  $alunoId = (int)$alunoId;
  return $conn->query("DELETE FROM aluno_advertencia WHERE advertencia_id=$advertenciaId AND aluno_id=$alunoId");
}