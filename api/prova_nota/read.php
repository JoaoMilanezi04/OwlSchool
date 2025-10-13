<?php
require_once __DIR__ . '/../../db/conexao.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $prova_id = $_POST['prova_id'] ?? '';
  if ($prova_id === '') { echo json_encode(['success'=>false,'message'=>'prova_id obrigatório']); exit; }

  $sql = "SELECT prova_id, aluno_id, nota
            FROM prova_nota
           WHERE prova_id = $prova_id
           ORDER BY aluno_id";
  $rs = $conn->query($sql);

  if ($rs) {
    $notas = [];
    while ($r = $rs->fetch_assoc()) $notas[] = $r;
    echo json_encode(['success'=>true,'notas'=>$notas]);
  } else {
    echo json_encode(['success'=>false,'message'=>'Erro ao listar: '.$conn->error]);
  }
} else {
  echo json_encode(['success'=>false,'message'=>'Método inválido.']);
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
