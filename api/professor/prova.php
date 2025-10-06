<?php

require __DIR__ . '/../../db/conexao.php';







function createProva($titulo, $data) {
    global $conn;
    $sql = "INSERT INTO prova (titulo, data) VALUES ('$titulo', '$data')";
    $conn->query($sql);
    return $conn->insert_id;
}





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






function deleteProvaById($id) {
    global $conn;
    $sql1 = "DELETE FROM prova_nota WHERE prova_id = $id";
    $conn->query($sql1);
    $sql2 = "DELETE FROM prova WHERE id = $id";
    $conn->query($sql2);
}







function listProvas() {
    global $conn;
    $sql = "SELECT id, titulo, data FROM prova ORDER BY data DESC, id DESC";
    $resultado = $conn->query($sql);
    $provas = [];
    while ($linha = $resultado->fetch_assoc()) $provas[] = $linha;
    return $provas;
}







function listAlunosComNota($provaId) {
    global $conn;
    $sql = "
        SELECT
            a.usuario_id AS aluno_id,
            COALESCE(u.nome, CONCAT('Aluno #', a.usuario_id)) AS nome,
            pn.nota
        FROM aluno a
        LEFT JOIN usuario u ON u.id = a.usuario_id
        LEFT JOIN prova_nota pn ON pn.aluno_id = a.usuario_id AND pn.prova_id = $provaId
        ORDER BY nome ASC, aluno_id ASC
    ";
    $resultado = $conn->query($sql);
    $alunos = [];
    while ($linha = $resultado->fetch_assoc()) $alunos[] = $linha;
    return $alunos;
}







function upsertNota($provaId, $alunoId, $nota) {
    global $conn;
    $sql = "
        INSERT INTO prova_nota (prova_id, aluno_id, nota)
        VALUES ($provaId, $alunoId, '$nota')
        ON DUPLICATE KEY UPDATE nota = VALUES(nota)
    ";
    $conn->query($sql);
}







function saveNotasEmMassa($provaId, $mapNotas) {
    foreach ($mapNotas as $alunoId => $nota) {
        upsertNota($provaId, $alunoId, $nota);
    }
}
