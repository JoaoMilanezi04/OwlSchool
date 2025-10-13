<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $prova_id = $_POST['prova_id'] ?? '';
  $aluno_id = $_POST['aluno_id'] ?? '';

  $ok = $conn->query("DELETE FROM prova_nota WHERE prova_id=$prova_id AND aluno_id=$aluno_id");

  if ($ok) echo json_encode(['success'=>true,'message'=>'Nota excluída.']);
  else echo json_encode(['success'=>false,'message'=>'Erro ao excluir: '.$conn->error]);
} else {
  echo json_encode(['success'=>false,'message'=>'Método inválido.']);
}


function deleteNotasByProva($provaId) {
    global $conn;
    $sql = "DELETE FROM prova_nota WHERE prova_id = $provaId";
    $conn->query($sql);
}