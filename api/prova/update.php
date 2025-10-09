<?php



require __DIR__ . '/../../db/conexao.php';




function updateProva($id, $titulo, $data) {
  global $conn;
  $sql = "
    UPDATE prova
       SET titulo = '$titulo',
           data   = '$data'
     WHERE id = $id
  ";
  $conn->query($sql);
}